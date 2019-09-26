<?php

namespace Mikofb\Mikdoc\Models;


use Storage;

/**
 * 
 *
 *
 *
 */

//TODO

/**
 * Please check a root directory is created. If not, just create it with way:
 * 
 * [
 *	'name' => 'root',
 *	'slug' => 'root'
 * ]
 *
 * And that's all !
 */
class Mikdoc
{
	/**
	 * Create a blank document in the root folder by default
	 *
	 * @param int $parent
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
	public function blankDocument($parent = 1)
    {
        return Document::create(['document_id' => $parent]);
    }

    /**
	 * Create a blank folder
	 *
	 * @param int $parent
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function blankFolder($parent)
    {
        $temp = $this->blankDocument($parent);
        $temp->is_file = 0;
        $temp->save();
        return $temp;
    }

    /**
	 * Create a blank file
	 *
	 * @param int $parent
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function blankFile($parent)
    {
        $temp = $this->blankDocument($parent);
        $temp->is_file = 1;
        $temp->save();
        return $temp;
    }

    /**
	 * Create a new document by providing params
	 *
	 * @param string $name|int $size, $parent, $user|boolean $is_file
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function createDocument($name, $size = null, $is_file = null, $parent = 1, $user = null)
    {
    	$t = $this->getUsingName($name);
        if (is_null($t) || !$t->parent()->contains($name))
        {
        	$temp = $this->blankDocument($parent);
	        $temp->name = $name;
	        $temp->slug = str_slug($name, $separator = '-');
	        $temp->size = $size;
	        $temp->is_file = $is_file;
	        $temp->user_id = $user;
	        $temp->save();
	        return $temp;
        }return null;
    }

    /**
	 * Create a new folder by providing params
	 *
	 * @param string $name|int $size, $parent, $user
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function createFolder($name, $parent, $user)
    {
    	return $this->createDocument($name, null, false, $parent, $user);
    }

    /**
	 * Create a new file by providing params
	 *
	 * @param string $name|int $size, $parent, $user
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function createFile($name, $size, $parent, $user)
    {
    	return $this->createDocument($name, $size, true, $parent, $user);
    }

    /**
	 * Store a new uploaded
	 *
	 * @param string $name
	 * @return boolean
	 */
    public function storeFile($name, $file)
    {
    	try 
    	{
            if (!Storage::disk(config('mikdoc.disk'))->exists($name)) 
            {
	            try
	            {
	                Storage::disk(config('mikdoc.disk'))->put($name, file_get_contents($file));
	                return true;
	            }
	            catch(ErrorException $e)
	            {   

	            }                   
	        }
        }
        catch (ErrorException $e) 
        {
            
        }
        return false;
    }

    /**
	 * Delete a stored file
	 *
	 * @param string $name
	 * @return void
	 */
    public function deleteFile($name)
    {
    	try 
    	{
            if (Storage::disk(config('mikdoc.disk'))->exists($name)) 
            {
                Storage::disk(config('mikdoc.disk'))->delete($name);
            }
        }
        catch (ErrorException $e) 
        {
            
        }
    }

    /**
	 * Update a stored file
	 *
	 * @param string $old_name, $new_name
	 * @return void
	 */
    public function renameFile($old_name, $new_name)
    {
        try 
        {
        	if (Storage::disk(config('mikdoc.disk'))->exists($old_name)) 
        	{
	            Storage::disk(config('mikdoc.disk'))->put($new_name, Storage::disk(config('mikdoc.disk'))->get($old_name));
	            Storage::disk(config('mikdoc.disk'))->delete($old_name); 
	        }
        } catch (Exception $e) {
        	
        }
    }

    /**
	 * Checks if the given id exists or not
	 *
	 * @param int $id
	 * @return boolean
	 */
    public function existsId($id)
    {
        if (!is_null($this->getUsingId($id))) 
        {
        	return true;
        }
        return false;
    }

    /**
	 * Checks if the given name exists or not
	 *
	 * @param string $name
	 * @return boolean
	 */
    public function existsName($name)
    {
        if (!is_null($this->getUsingName($name))) 
        {
        	return true;
        }
        return false;
    }

    /**
	 * Checks if the given slug exists or not
	 *
	 * @param string $slug
	 * @return boolean
	 */
    public function existsSlug($slug)
    {
        if (!is_null($this->getUsingName($slug))) 
        {
        	return true;
        }
        return false;
    }

    /**
	 * Find a document using its id property
	 *
	 * @param int $id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getUsingId($id)
    {
        return Document::find($id);
    }

    /**
	 * Find a document using its name property
	 *
	 * @param string $name
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getUsingName($name)
    {
        return Document::where('name', $name)->first();
    }

    /**
	 * Find a document using its slug property
	 *
	 * @param string $slug
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getUsingSlug($slug)
    {
        return Document::where('slug', $slug)->first();
    }

	/**
	 * Display the content of current directory that belongs to the given user
	 * 
	 * @param int $user_id, $document_id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function explore($user_id, $document_id)
	{
		if ($this->existsId($document_id) && !$this->getUsingId($document_id)->is_file()) 
		{
			return Document::where([
				['user_id', $user_id],
				['document_id', $document_id]
			])->orderBy('is_file', 'ASC')->paginate(config('mikdoc.paginate'));
		}
	}

	/**
	 * Display the content of current directory
	 * 
	 * @param int $user_id, $document_id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function _explore($document_id)
	{
		if ($this->existsId($document_id) && !$this->getUsingId($id)->is_file()) 
		{
			return Document::where('document_id', $document_id)->orderBy('is_file', 'ASC')->paginate(50);
		}
	}

    /**
	 * Get all created document
	 *
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function _getAll()
	{
		return Document::all();
	}

    /**
	 * Get all created folders
	 *
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function _getAllFolders()
	{
		return Document::where('is_file', 0)->get();
	}

	/**
	 * Get all created files
	 *
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
	public function _getAllFiles()
	{
		return Document::where('is_file', 1)->get();
	}

	/**
	 * Create a new document
	 *
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
	public function _getAllDocumentsSize()
	{
		$bytes = 0;
		foreach ($this->getAllFiles() as $file) 
		{
			$temp = env('APP_NAME').''.strtotime($file->created_at).'_'.$file->name;
			if (Storage::disk(config('mikdoc.disk'))->exists($temp)) 
			{
                $bytes += filesize(Storage::disk(config('mikdoc.disk'))->path($temp));  
            }
		}
		return $this->sizeForHumans($bytes);
	}

	/**
	 * Get the count of all created documents
	 *
	 * @return int
	 */
    public function _countAll()
    {
		return $this->_getAll()->count();
	}

	/**
	 * Get the count of all created folders
	 *
	 * @return int
	 */
    public function _countAllFolders()
    {
		return $this->_getAllFolders()->count();
	}

	/**
	 * Get the count of all created files
	 *
	 * @return int
	 */
    public function _countAllFiles()
    {
		return $this->_getAllFiles()->count();
	}

	/**
	 * Get the count of all created documents for the given user
	 *
	 * @param int $user_id
	 * @return int
	 */
    public function countAll($user_id)
    {
		return $this->getAll($user_id)->count();
	}

	/**
	 * Get the count of all created folders for the given user
	 *
	 * @param int $user_id
	 * @return int
	 */
    public function countAllFolders($user_id)
    {
		return $this->getAllFolders($user_id)->count();
	}

	/**
	 * Get the count of all created files for the given user
	 *
	 * @param int $user_id
	 * @return int
	 */
    public function countAllFiles($user_id)
    {
		return $this->getAllFiles($user_id)->count();
	}

	/**
	 * Get all created documents for the given user
	 *
	 * @param int $user_id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getAll($user_id)
    {
		return Document::where('user_id', $user_id)->get();
	}

	/**
	 * Get all created folders for the given user
	 *
	 * @param int $user_id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getAllFolders($user_id)
    {
		return Document::where(
			[
				['user_id', $user_id],
				['is_file', false],
			])->get();
	}

	/**
	 * Get all created file for the given user
	 *
	 * @param int $user_id
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function getAllFiles($user_id)
    {
		return Document::where(
			[
				['user_id', $user_id],
				['is_file', true],
			])->get();
	}

	/**
	 * Create a new folder for an user
	 *
	 * @return \Mikofb\Mikdoc\Models\Document
	 */
    public function newFolderFor($user_id)
    {
        $temp = $this->newFolder();
        $temp->user_id = $user_id;
        $temp->save();
        return $temp;
    }

    /*---------------------------------------------------
     * The following methods are utilities methods
     *---------------------------------------------------*/

    /**
	 * Returns the size from bytes to humans
	 *
	 * @param $bytes
	 * @return string
	 */
    public function sizeForHumans($bytes, $decimals = 2) 
    {
	  $size = 'BKMGTP';
	  $factor = floor((strlen($bytes) - 1) / 3);
	  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}
}