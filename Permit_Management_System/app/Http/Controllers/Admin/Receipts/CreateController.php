<?php

namespace App\Http\Controllers\Admin\Receipts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function create()
    {
        return view('admin.receipts.create');
    }
}