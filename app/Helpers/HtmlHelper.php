<?php

namespace App\Helpers;

class HtmlHelper
{
    public static function editButton($path, $value = 'Edit')
    {
        $data = NULL;
        if ($path) {
            $data = '<a class="btn btn-sm btn-outline-dark btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit" href="' . $path . '">Edit</a>';
        }
        return $data;
    }

    public static function deleteButton($id, $value = 'Delete')
    {
        $data = NULL;
        if ($id) {
            $data = '<a class="btn btn-sm btn-outline-dark btn-text-danger btn-hover-danger btn-icon mr-2" title="Delete" href="javascript:;" id="' . $id . '" onclick="ajaxDelete(this.id)">Delete</a>';
        }
        return $data;
    }
}

