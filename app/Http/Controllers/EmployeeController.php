<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Mail\Image\ImagesMail;

class EmployeeController extends Controller {

    // set index page view
    public function index() {
        return view('index');
    }

    // handle fetch all eamployees ajax request
    public function fetchAll() {
        $emps = Employee::all();
        $output = '';
        if ($emps->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Изображение</th>
                <th>Название</th>
                <th>URL</th>
                <th>Размер</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($emps as $emp) {
               $bite =  $emp->file_size;
               $kbite = $bite / 1000;
                $output .= '<tr>
                <td>' . $emp->id . '</td>
                <td><img src="storage/images/' . $emp->avatar . '" width="50" class="img-thumbnail img_w-100"></td>
                <td>' . $emp->title. '</td>
                <td><a href="/storage/images/'.$emp->avatar.'" class="img-link">' .'Перейти'. '</a></td>
                <td>' ."$kbite кб". '</td>

              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary my-5">В базе данных изображения не найдены!</h3>';
        }
    }

    // handle insert a new employee ajax request
    public function store(Request $request) {
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);
        $empData = ['title' => $request->fname,'avatar' => $fileName,'file_size' => filesize($file)];
        Employee::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

}
