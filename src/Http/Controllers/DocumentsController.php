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
		// Mikdoc::path($document);
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
                	if ($parent->contains($filename)) {
                		return \Response::json(array('exists' => true ));
                	}
                }
                else
                {
                	return \Response::json(array('error' => true ));
                }

                $temp = Mikdoc::createFile($filename, Mikdoc::sizeForHumans(filesize($file)), $parent->id, auth()->user()->id);
                if (is_null($temp)) {
                	# code...
                }
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
		if ($document->name != $request->name && !$document->parent()->contains($request->name)) 
		{
			if ($document->is_file()) 
			{
				$old_name = strtotime($document->created_at).'_'.$document->name;
	        	$new_name = strtotime($document->created_at).'_'.$request->name;
	        	Mikdoc::renameFile($old_name, $new_name);
			}

	        $document->rename($request->name);
		}

		if (!is_null($parent) && $parent->id != $document->parent()->id) 
	    {
	        $document->changeParent($parent->id);
	    }
		return redirect()->route(config('mikdoc.routes.prefix').'.operations', $document->slug);
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

	public function search()
	{
		 
	}

	public function search_query($value)
	{
		$output = '';
		$type = '';
		$color = '';
		foreach (Mikdoc::getAll(auth()->user()->id) as $doc) 
		{
			if ($doc->name == $value) {
				if ($doc->is_file()) {
					$type = 'file';
					$color = "blue";
				}
				else{
					$type = 'folder';
					$color = "yellow";
				}
				$output = $output."<tr>
	                            <th scope='row'>
	                              <div class='media align-items-center'>
	                                <a href='#' class='icon icon-shape bg-secondary text-".$color." rounded-circle shadow'>
	                                  <i class='fas fa-".$type."'></i>
	                                </a>
	                                <div class='media-body'>
	                                  <span class='mb-0 text-sm'>
	                                    <a href='".route(config('mikdoc.routes.prefix').'.show', $doc->parent()->slug)."' class='font-weight-light text-muted'>
	                                      ".$doc->parent()->name." /
	                                    </a>
	                                    <a href='".route(config('mikdoc.routes.prefix').'.show', $doc->slug)."' class='font-weight-light'>
	                                      ".$doc->name."
	                                    </a>
	                                  </span>
	                                </div>
	                              </div>
	                            </th>
	                          </tr>";
			}
		}
		if ($output != '') {
			return \Response::json($output);
		}
		return \Response::json(trans('mikdoc::messages.no_matches')); 
	}
}