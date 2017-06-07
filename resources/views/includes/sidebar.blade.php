<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-files-o"></i> <span>XLS Uploads</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Data Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @permission(['user-view','user-edit','user-create','user-delete'])
                      <li><a href="{!!route('userList')!!}"><i class="fa fa-circle-o"></i> Users List</a></li>
                    @endpermission
                    @permission(['role-view','role-edit','role-create','role-delete'])
                      <li><a href="{!!route('roles.index')!!}"><i class="fa fa-circle-o"></i> Roles List</a></li>
                    @endpermission
                    @permission(['project-view','project-edit','project-create','project-delete'])
                      <li><a href="{!!route('projectList')!!}"><i class="fa fa-circle-o"></i> Projects List</a></li>
                    @endpermission
                    @permission(['activity-view','activity-edit','activity-create','activity-delete'])
                      <li><a href="{!!route('activityList')!!}"><i class="fa fa-circle-o"></i> Activity List</a></li>
                    @endpermission
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
