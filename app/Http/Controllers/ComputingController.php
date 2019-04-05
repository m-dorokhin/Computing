<?php

namespace App\Http\Controllers;

use App\Code;
use App\Post;
use App\Comment;
use App\Tag;
use App\Computing;
use App\CodeSearcher;
use Illuminate\Http\Request;

class ComputingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $computing = Computing::find($id);

        if (!isset($computing))
            return abort(404);

        return view('post')
            ->with('computing', $computing);
    }

    /**
     * Вывести форму редактора постов
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editor()
    {
        return view('editor');
    }

    /**
     * Сохранение поста
     *
     * @param Request $request
     * @return Response
     */
    public  function save(Request $request)
    {
        $computing = new Computing();
        $computing->title = $request->title;
        $computing->text = $request->text;
        $request->user()->computing()->save($computing);

        $code_searcher = new CodeSearcher($request->text);
        $current_codes = $code_searcher->get_cods();
        $codes = Code::whereIn('code', $current_codes)->get();
        if (count($codes) > 0) {
            $computing->codes()->saveMany($codes);
            $exist_codes = array_column($codes->toArray(), 'code');
            $notexist_codes = array_diff($current_codes,
                $exist_codes);
        }
        else
        {
            $notexist_codes = $current_codes;
        }
        foreach ($notexist_codes as $code)
        {
            $new_code = new Code();
            $new_code->code = $code;
            $computing->codes()->save($new_code);
        }

        return redirect('/');
    }
}
