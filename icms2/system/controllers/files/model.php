<?php
class modelFiles extends cmsModel {

    public function registerFile($file){

        $file['size'] = filesize(cmsConfig::get('upload_path').$file['path']);

        return $this->insert('uploaded_files', $file);

    }

    public function deleteFile($id){

        $file = $this->getFile($id);
        if(!$file){ return false; }

        $is_unlink = @unlink(cmsConfig::get('upload_path').$file['path']);

        $is_delete = $this->delete('uploaded_files', $file['id']);

        return $is_unlink && $is_delete;

    }

    public function getFile($id){
        return $this->getItemById('uploaded_files', $id);
    }

    public function getFileByPath($path){
        return $this->getItemByField('uploaded_files', 'path', $path);
    }

    public function incrementDownloadsCounter($file_id){
        return $this->filterEqual('id', $file_id)->increment('uploaded_files', 'counter');
    }

    public function filterFileType($type) {
        return $this->filterEqual('type', $type);
    }

    public function getFiles(){

        $this->selectOnly('id');
        $this->select('path');
        $this->select('name', 'title');

        return $this->get('uploaded_files', function($item, $model){

            $item['image'] = cmsConfig::get('upload_host') . '/' . $item['path'];
            $item['thumb'] = $item['image'];
            $item['value'] = $item['image'];

            return $item;

        });

    }

}
