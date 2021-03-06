<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\Leader;
use App\Models\LocList;
use App\Models\Nav;
use App\Models\Tag;
use App\Models\Type;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ActivityController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('活动');
            $content->description('index');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('活动');
            $content->description('edit');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('活动');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Activity::class, function (Grid $grid) {
            $grid->model()->with('admin')->withCount(['trips', 'orders' => function($query){
                $query->where('status', 'success');
            }]);
            $grid->id('ID')->sortable();
            $grid->column('title', '标题')->limit(40);
            $grid->column('short', '短标题')->limit(20);
            $grid->column('price', '显示价格')->sortable()->editable();
            $grid->column('orders_count', '已支付')->badge();
            $grid->column('trips_count', '游玩天数')->badge();
            $grid->column('closed', '上架状态')->switch([
                'on' => ['value' => 0, 'text' => '上架', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '下架']
            ]);
            $grid->column('admin.name', '作者');
            $grid->updated_at('修改日期');
            $grid->filter(function ($filter) {
                $filter->in('navs.id', '导航')->multipleSelect(Nav::pluck('text', 'id'));
                $filter->equal('closed', '上架状态')->radio(['' => '全部', 0 => '上架', 1 => '下架']);
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '更新时间')->datetime();
            });

            $grid->actions(function ($actions) {
                $a = sprintf('<a href="%s" target="_blank"><i class="fa fa-fw fa-paper-plane"></i></a>', route('activity.show', $actions->row));
                $actions->prepend($a);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Activity::class, function (Form $form) {

            $form->tab('基本信息', function (Form $form) {
                $form->hidden('admin_user_id')->default(Admin::user()->id);
                $form->text('title', '标题')->rules('required|string|max:200');
                $form->text('short', '短标题')->rules('required|string|max:200');

                $form->image('thumb', '缩略图')->rules('required')->uniqueName();
                $form->multipleImage('photos', '轮播图')->removable()->uniqueName();

                $form->text('number', '产品编号')->rules('nullable|string|max:200');
                $form->text('cfd', '出发地点')->rules('required|string|max:50')->default('四川-成都');
                $form->number('price', '显示价格')->rules('required')->help('产品会显示此价格')->default(5000);
                $form->textarea('description', '产品描述')->rules('required|string|max:250');
                $form->text('xc', '行程描述')->rules('required|string|max:200');

                $form->textarea('ts', '行程特色简介')->rules('required');
                $form->multipleImage('tps', '行程特色图片')->removable()->help('3张图片')->uniqueName();

                $form->switch('closed', '上架状态')->states([
                    'on' => ['value' => 0, 'text' => '上架', 'color' => 'success'],
                    'off' => ['value' => 1, 'text' => '下架']
                ]);
            })->tab('注意事项', function (Form $form) {
                $form->textarea('baohan', '费用包含');
                $form->textarea('buhan', '费用不含');
                $form->textarea('zhuyi', '注意事项');
                $form->textarea('qianyue', '签约条款');
            })->tab('关联地区', function (Form $form) {
                $form->select('country_id', '国家')->options(
                    LocList::country()->pluck('name', 'id')
                )->load('province_id', '/admin/api/province')->rules('required');

                $form->select('province_id', '省份')->options(
                    LocList::province()->pluck('name', 'id')
                )->load('city_id', '/admin/api/city')->rules('required');

                $form->select('city_id', '城市')->options(function ($id) {
                    return LocList::options($id);
                })->load('district_id', '/admin/api/district');

                $form->select('district_id', '地区')->options(function ($id) {
                    return LocList::options($id);
                });
            })->tab('行程安排', function (Form $form) {
                $form->hasMany('trips', '行程', function (Form\NestedForm $form) {
                    $form->text('title', '行程标题')->rules('required|string');
                    $form->multipleFile('pictures', '展示图')->removable()->help('3张图片')->uniqueName();
                    $form->textarea('body', '行程内容')->rows(10)->rules('required|string');
                    $form->text('zaocan', '早餐')->default('包含');
                    $form->text('wucan', '午餐')->default('包含');
                    $form->text('wancan', '晚餐')->default('包含');
                    $form->text('zhusu', '住宿')->default('包含');
                });
            })->tab('出团安排', function (Form $form) {
                $form->hasMany('tuans', '出团日期', function (Form\NestedForm $form) {
                    $form->dateRange('start_time', 'end_time', '报名日期')->rules('required');
                    $form->number('start_num', '开始人数')->rules('required')->help('初始显示人数');
                    $form->number('end_num', '截止人数')->rules('required')->help('可报名人数=截止人数-开始人数');
                    $form->number('price', '购买价格')->rules('required')->help('每人需要支付的价格');
                });
            })->tab('领队与标签', function (Form $form) {
                $form->multipleSelect('leaders', '领队')->options(Leader::pluck('name', 'id'))->rules('required');
                $form->multipleSelect('navs', '导航')->options(Nav::pluck('text', 'id'))->rules('required');
                $form->multipleSelect('types', '类别')->options(Type::pluck('text', 'id'))->rules('required');
                $form->multipleSelect('tags', '标签')->options(Tag::pluck('text', 'id'));
            });
        });
    }

}
