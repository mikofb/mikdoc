<?php

namespace Mikofb\Mikdoc\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{

    protected $guarded = [];

    /**
     * Return the owner of the current document
     * 
     * @return \App\User
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Checks if the current folder contains document with the given name
     *
     * @param string $name
     * @return boolean
     */
    public function contains($name)
    {
        foreach ($this->documents as $document) {
            if ($document->name == $name) {
                return true;
            }
        }return false;
    }

    /**
     * Gets the current folder children
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany of \Mikofb\Documents\Models\Document
     */
    public function documents(){
        if (!$this->is_file()) {
            return $this->hasMany(Document::class)->orderBy('is_file', 'ASC');
        }
    }

    /**
     * Checks if the current folder is empty or not
     *
     * @return boolean
     */
    public function is_empty(){
        if (!$this->is_file()) {
            if ($this->documents()->count() == 0) {
                return true;
            }
            return false;
        }
    }

    /**
     * Checks if the current document is a file or not
     * 
     * @return boolean
     */
    public function is_file(){
    	return $this->is_file == 1 ? true : false;
    }

    /**
     * Returns the current document parent directory
     *
     * @return \Mikofb\Documents\Models\Document
     *
     */
    public function parent(){
    	return Document::find($this->document_id);
    }

    /**
     * Checks if current folder contains document with the given id
     *
     * @param int $id
     * @return boolean
     *
     */
    public function has($id){
        foreach ($this->documents as $doc) {
            if ($doc->id == $id) {
                return true;
            }
        }return false;
    }

    /**
     * Change the document's parent
     *
     * @param int $id
     * @return \Mikofb\Documents\Models\Document
     *
     */
    public function changeParent($id){
        $this->document_id = $id;
        $this->save();
    }

    /**
     * Renames the current document
     *
     * @param $name
     */
    public function rename($name)
    {
    	$this->name = $name;
        $this->slug = Str::slug($name, '-');
    	$this->save();
    }

    /**
     * Move the current document from one directory to another one
     *
     * @param int $destination
     */
    public function move($destination)
    {
    	$this->document_id = $destination;
    	$this->save();
    }
}
