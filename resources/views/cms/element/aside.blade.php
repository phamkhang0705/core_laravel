<?php
$route_current = \Illuminate\Support\Facades\Route::currentRouteName();

?>

<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- Menu -->
        <div class="menu">
            <ul class="list">

                <?php

                /**@var $current_path */
                if(!empty($menus)) {
                $all_actions = [];

                $current_path = trim($current_path, '/');

                foreach ($menus as $menu) {
                    foreach ($menu['actions'] as $kaction => $action) {
                        $all_actions[] = trim($kaction, '/');
                    }
                }
                $current_path_arr = explode('/', $current_path);
                //trim($current_path,'/') !=''
                if (count($current_path_arr) >= 2) {
                    $current_path = explode('/', trim($current_path, '/'))[0] . '/' . explode('/', trim($current_path, '/'))[1];

                    if (!in_array($current_path, $all_actions)) {
                        $current_path = explode('/', trim($current_path, '/'))[0];
                    }
                }
                //

                foreach($menus as $menu) {

                $big_menu_active = false;
                $big_menu_url = trim($menu['url'], '/');

                if ($current_path == $big_menu_url) {
                    $big_menu_active = true;
                } else if (!empty($menu['actions'])) {
                    foreach ($menu['actions'] as $k => $tmp1) {


                        if ($current_path == trim($k, '/')) {
                            $big_menu_active = true;

                            break;
                        }
                        unset($tmp1);
                    }
                }

                ?>
                <li class="{{ !empty($current_path) && $big_menu_active == true?'active':'' }}">
                    <a href="{{ !empty($big_menu_url)?'/'.$big_menu_url:'javascript:void(0)' }}"
                       class="{{ !empty($menu['actions'])?'menu-toggle':'' }}">
                        <i class="material-icons">{{ isset($menu['class']) ? $menu['class']:''}}</i>
                        <span>{{ $menu['title'] }}</span>
                    </a>


                    <?php if(!empty($menu['actions'])) { ?>
                    <ul class="ml-menu">
                        <?php
                        foreach($menu['actions'] as $k=>$item) {
                        $sub_menu_url = trim($k, '/');
                        ?>
                        <li class="
                                        @if($current_path == $sub_menu_url)
                                active
@endif
                                ">
                            <a href="{{ !empty($sub_menu_url)?'/'.$sub_menu_url:'javascript:void(0)' }}">
                                {{ $item['title'] }}
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <?php }?>
                </li>

                <?php
                }
                }?>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2018 <span class="version">version 2.0</span> <a href="javascript:void(0);">by deal365.vn </a>
            </div>

        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->

    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#account" data-toggle="tab">CÁ NHÂN</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">CÀI ĐẶT KHÁC</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="account">
                <p class="username">{{auth()->user()->name}}</p>

                <ul class="setting-list">
                    <li>
                        <a href="{!! route('cms.my.index') !!}" class=" waves-effect waves-block">
                            <i class="material-icons">person</i>Thông tin cá nhân
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('cms.my.change_password') !!}" class=" waves-effect waves-block">
                            <i class="material-icons">lock</i>Đổi mật khẩu
                        </a>
                    </li>
                    <li><a href="{{action('Cms\Auth@logout')}}" class=" waves-effect waves-block">
                            <i class="material-icons">input</i>Đăng xuất</a>
                    </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>GENERAL SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>