<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.19
 * Time: 19:52
 */

namespace App\Http\Controllers;

use App\Code;
use App\Computing;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($page=1)
    {
        if ($page < 1)
            $page = 1;

        $count = Computing::all()->count();

        $take = 10;
        $count_pages = ceil($count / $take);
        if ($page > $count_pages)
            $page = $count_pages;

        $skip = ($page-1)*$take;

        $computing = Computing::orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($take)
            ->with('codes')
            ->get();

        return view('home')
            ->with('title', 'Все рассчёты')
            ->with('computings', $computing)
            ->with('page', $page)
            ->with('count', $count_pages)
            ->with('route', 'home')
            ->with('query', '');
    }

    public function code($page=1)
    {
        if ($page < 1)
            $page = 1;

        $request = Request::all();
        $operation = $request['operation'];
        $search = $request['search'];

        $where = function ($query) use($operation, $search) {
            $query->where('code', $operation, $search);
        };

        $count = Computing::whereHas('codes', $where)->count();

        $take = 10;
        $count_pages = ceil($count / $take);
        if ($page > $count_pages)
            $page = $count_pages;

        $skip = ($page-1)*$take;

        $computing = Computing::whereHas('codes', $where)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($take)
            ->with('user')
            ->get();

        return view('home')
            ->with('title', 'Рассчёты для условия: '.$operation.' '.$search)
            ->with('computings', $computing)
            ->with('page', $page)
            ->with('count', $count_pages)
            ->with('route', 'search')
            ->with('query', '?operation='.$operation.'&search='.$search);
    }
}