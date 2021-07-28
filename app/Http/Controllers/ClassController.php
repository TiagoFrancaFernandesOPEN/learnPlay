<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClassUsers;
use App\Models\Classes;

class ClassController extends Controller {

    public function class(){

        $classes = ClassUsers::getClassByUser(Auth::user()->id);

        return view('painel.class.my', compact('classes'));
    }

    public function class_page($id, $className = null){

        $class = new \StdClass();
        if(!(bool) Classes::getClassById($id)){
            $class = false;

        }else{
            $class->title = Classes::getClassById($id)->titulo;
            $class->all = Classes::getClassById($id);
            if($class->all->tipo_restricao == 'password'){ $class->all->tipo_restricao = 'senha'; }
            $class->all->timestamp = new \DateTime($class->all->timestamp);
            $class->all->timestamp = $class->all->timestamp->format('d/m/Y à\s H:i');
            $class->users = Classes::getClassUsers($id);
        }

        return view('painel.class.page', compact('id', 'class'));

    }

    public function class_leave(Request $request){
        ClassUsers::leave([
            'id_class' => $request->id,
            'id_user' => Auth::user()->id
        ]);

        return back();
    }

    public function class_matricula(Request $request){

        ClassUsers::matricular([
            'id_class' => $request->id,
            'id_user' => Auth::user()->id
        ]);

        return back();

    }

    public function class_public(){
        $classes = Classes::getClasses();

        return view('painel.class.public', compact('classes'));
    }

    public function class_category($category) {

        $category = ucfirst(urldecode($category));

        $classes = Classes::getClasses($category);

        return view('painel.class.category', compact('category', 'classes'));

    }

    public function class_search(Request $request){
        $name = ucfirst(urldecode($_GET['query']));

        $classes = Classes::searchClass($name);

        return view('painel.class.search', ['query' => $name, 'classes'=>$classes]);

    }


}
