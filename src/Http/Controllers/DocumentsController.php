<?php

namespace Mikofb\Mikdoc\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Mikdoc;
use Storage;
use File;

class DocumentsController extends Controller
{
	public function index()
	{
		return $this->show('root');
	}

	public function show($slug)
	{
		$document = Mikdoc::getUsingSlug($slug);
		abort_unless(!is_null($document), 404, 'Document not found');
		if ($document->is_file()) 
		{
			return redirect()->route(config('mikdoc.routes.prefix').'.load', $document->slug);
		}
		else
		{
			return view('mikdoc::documents.show')
					->with('documents', Mikdoc::explore(auth()->user()->id, $document->id))
					->with('dossier', $document);
		}
		return view('mikdoc::documents.show');
	}

	public function operations($slug)
	{
		$document = Mikdoc::getUsingSlug($slug);
		abort_unless(!is_null($document), 404, 'Document not found');
		return view('mikdoc::documents.operations')
                    ->with('document', $document)
                    ->with('dossiers', Mikdoc::getAllFolders(auth()->user()->id));
	}

	public function load($slug)
    {
        $document = Mikdoc::getUsingSlug($slug);
		abort_unless(!is_null($document), 404, 'Document not found');
        $file_to_read = strtotime($document->created_at).'_'.$document->name;

        if(Storage::disk(config('mikdoc.disk'))->exists($file_to_read))
        {
            $mime = File::mimeType(Storage::disk(config('mikdoc.disk'))->path($file_to_read));
            $content_type = '';
            $content_disposition = '';

            if ($mime == 'application/pdf') {
                $content_type = 'application/pdf';
            }
            elseif($mime == 'image/png')
            {
                $content_type = 'image/png';
            }
            elseif($mime == 'image/jpeg')
            {
                $content_type = 'image/jpeg';
            }
            elseif($mime = 'text/plain')
            {
                $content_type = 'text/plain';
            }
            else
            {
                return back();
            }

            return \Response::make(file_get_contents(Storage::disk(config('mikdoc.disk'))->path($file_to_read)), 200, [
                'Content-Type'=> $content_type,   
                'Content-Disposition' => 'inline; filename="'.$document->nom.'"'
            ]);
        }
        return back();
    }

	public function store(Request $request)
	{
		if (!is_null(Mikdoc::createFolder($request->name, $request->parent, auth()->user()->id))) {
			return \Response::json(array('success' => true ));
		}
		return \Response::json(array('error' => true ));
	}

	public function upload(Request $request)
	{
		$error = 0;
        $filename = '';
        $file_to_store = '';
        $files = $request->file('file');

        if (!empty($files)) 
        {  
            foreach ($files as $file) 
            {
                $filename = $file->getClientOriginalName();
                $parent = Mikdoc::getUsingId($request->parent);

                if (!is_null($parent)) 
                {
                	foreach ($parent->documents() as $document) 
                	{
	                    if ($document->name == $filename) 
	                    {
	                        return \Response::json(array('exists' => true ));
	                    }
	                }
                }
                else
                {
                	return \Response::json(array('error' => true ));
                }

                $temp = Mikdoc::createFile($filename, Mikdoc::sizeForHumans(filesize($file)), $parent->id, auth()->user()->id);
                $file_to_store = strtotime($temp->created_at).'_'.$filename;

                if (!Mikdoc::storeFile($file_to_store, $file)) 
                {
                	$temp->delete();
	                $error++;
                }
            }

            if ($error > 0) 
            {
                return \Response::json(array('error' => true ));
            }
            return \Response::json(array('success' => true ));
        }
        return \Response::json(array('empty' => true ));
	}

	public function update(Request $request, $id)
	{
		$document = Mikdoc::getUsingId($id);
		$parent = Mikdoc::getUsingId($request->parent);
		abort_unless(!is_null($document), 404, 'Document not found');
		if (!$document->parent()->contains($request->name)) 
		{
			if ($document->is_file()) 
			{
				$old_name = strtotime($document->created_at).'_'.$document->name;
	        	$new_name = strtotime($document->created_at).'_'.$request->name;
	        	Mikdoc::renameFile($old_name, $new_name);

			}
	        if (!is_null($parent) && $parent != $document->parent()) 
	        {
	        	$document->changeParent($parent->id);
	        }
	        $document->rename($request->name);
		}
		return back();
	}

	public function destroy($id)
	{
		$doc = Mikdoc::getUsingId($id);
		abort_unless(!is_null($doc), 404, 'Document not found');
		$parent = $doc->parent();
		if ($doc->is_file()) 
		{
			$filename = strtotime($doc->created_at).'_'.$doc->name;
			Mikdoc::deleteFile($filename);
			$doc->delete();
		}
		else
		{
			if ($doc->is_empty()) 
			{
				$doc->delete();
			}
			else
			{
				foreach ($doc->documents() as $document) 
				{
                    if ($document->is_file()) 
                    {
                    	Mikdoc::deleteFile($filename);
                    }
                    else
                    {
                    	if ($document->is_empty()) 
						{
							$document->delete();
						}
						else
						{
							foreach($document->document() as $temp)
							{
								if ($temp->is_file()) 
								{
									Mikdoc::deleteFile($filename);
								}
								$temp->delete();
							}
						}
                    }
                    $document->delete();
                }
                $doc->delete();
			}
		}
		return redirect()->route(config('mikdoc.routes.prefix').'.show', $parent->slug);
	}
}