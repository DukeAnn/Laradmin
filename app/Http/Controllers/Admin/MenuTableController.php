<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MenuTablePost;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\MenuRepositoryEloquent;

class MenuTableController extends Controller
{
    private $model_menu;
    /**
     * 依赖注入
     * @param MenuRepositoryEloquent $menu
     * */
    public function __construct(MenuRepositoryEloquent $menu)
    {
        //$this->middleware('check.permission');
        $this->model_menu = $menu;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->model_menu->getAllMenu();
        return view('admin.menu.menu_table' ,['menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //读取区父级分类
        $model_menu = $this->model_menu->model();
        $menu_first = $model_menu::where('parent_id', 0)->orderBy('order', 'asc')->get();
        return view('admin.menu.menu_add', ['menu_first' => $menu_first]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuTablePost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuTablePost $request)
    {
        if ($request->parent_id_1 == 0) {
            $parent_id = 0;
        } else {
            if ($request->parent_id_2 == 0) {
                $parent_id = $request->parent_id_1;
            } else {
                $parent_id = $request->parent_id_2;
            }
        }
        $responseData = $this->model_menu->createMenu($parent_id, $request);
        return response()->json($responseData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model_menu = $this->model_menu->model();
        $menu_info = $model_menu::find($id);
        return view('admin.menu.menu_edit' ,['menu_info' => $menu_info]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenuTablePost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuTablePost $request, $id)
    {
        $responseData = $this->model_menu->updateMenu($id, $request);
        return response()->json($responseData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model_menu->delAllMenu($id);
        $this->model_menu->setMenuAllCache();
        return response()->json(['state' => 'success']);
    }

    /**
     * AJAX获取二级分类
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetChildMenu(Request $request) {
        if ($request->parent_id != 0) {
            return $this->model_menu->getChildMenu($request->parent_id);
        }
    }

    /**
     * 保存排序
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveOrder(Request $request)
    {
        if (!empty($request->menu)) {
            $menu = json_decode($request->menu);
            $this->model_menu->saveMenuOrder($menu);
            $this->model_menu->setMenuAllCache();
            return response()->json(['state' => 'success']);
        }
    }
}
