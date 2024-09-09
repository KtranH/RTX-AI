<?php

namespace App;

use App\Models\Category;
use App\Models\User;

trait FindInformation
{
    //
    private function find_id()
    {
        $email = request()->cookie("token_account");
        $id = User::where("email",$email)->first();
        return $id->id;
    }
    private function find_id_categorie($x)
    {
        $id = Category::where("name",$x)->first();
        if($id != null)
        {
            return $id->id;
        }
        else
        {
            return 0;
        }
    }
}
