<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @permission(['otl-upload'])
            <li class="treeview">
                <a href="#">
                <i class="fa fa-files-o"></i> <span>DB Feed</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  @permission(['otl-upload'])
                    <li><a href="{!!route('otluploadform')!!}"><i class="fa fa-circle-o"></i> OTL upload</a></li>
                  @endpermission
                </ul>
            </li>
            @endpermission

            @permission(['user-view','user-edit','user-create','user-delete',
            'role-view','role-edit','role-create','role-delete',
            'project-view','project-edit','project-create','project-delete',
            'activity-view','activity-edit','activity-create','activity-delete'
            ])
            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>DB Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @permission(['user-view','user-edit','user-create','user-delete'])
                      <li><a href="{!!route('userList')!!}"><i class="fa fa-circle-o"></i> Users list</a></li>
                    @endpermission
                    @permission(['role-view','role-edit','role-create','role-delete'])
                      <li><a href="{!!route('roles.index')!!}"><i class="fa fa-circle-o"></i> Roles list</a></li>
                    @endpermission
                    @permission(['project-view','project-edit','project-create','project-delete'])
                      <li><a href="{!!route('projectList')!!}"><i class="fa fa-circle-o"></i> Projects list</a></li>
                    @endpermission
                    @permission(['activity-view','activity-edit','activity-create','activity-delete'])
                      <li><a href="{!!route('activityList')!!}"><i class="fa fa-circle-o"></i> Activity list</a></li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            @permission(['dashboard-view'])
            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                  @permission(['dashboard-view'])
                  <li><a href="{!!route('dashboardLoad')!!}"><i class="fa fa-circle-o"></i> Users load</a></li>
                  <li><a href="{!!route('dashboardLoadChart')!!}"><i class="fa fa-circle-o"></i> Users load Chart</a></li>
                  @endpermission
                </ul>

            </li>
            @endpermission
            @permission(['tools-activity-view'])
            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Tools</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                  @permission(['tools-activity-view'])
                  <li><a href="{!!route('toolsActivities')!!}"><i class="fa fa-circle-o"></i> Activity list per project</a></li>
                  <li><a href="{!!route('projectsAssignedAndNot')!!}"><i class="fa fa-circle-o"></i> Project assignment</a></li>
                  @endpermission
                </ul>

            </li>
            @endpermission
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
