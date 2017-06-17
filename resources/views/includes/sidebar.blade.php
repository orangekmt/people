<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">

    @permission(['otl-upload'])
    <ul class="nav side-menu">
      <li><a><i class="fa fa-home"></i>DB Feed <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          @permission(['otl-upload'])
            <li><a href="{!!route('otluploadform')!!}">OTL upload</a></li>
          @endpermission
        </ul>
      </li>
    </ul>
    @endpermission

    @permission(['user-view','user-edit','user-create','user-delete',
    'role-view','role-edit','role-create','role-delete',
    'project-view','project-edit','project-create','project-delete',
    'activity-view','activity-edit','activity-create','activity-delete'
    ])
    <ul class="nav side-menu">
      <li><a><i class="fa fa-edit"></i>DB Management <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          @permission(['user-view','user-edit','user-create','user-delete'])
          <li><a href="{!!route('userList')!!}">Users list</a></li>
          @endpermission
          @permission(['role-view','role-edit','role-create','role-delete'])
          <li><a href="{!!route('roles.index')!!}">Roles list</a></li>
          @endpermission
          @permission(['project-view','project-edit','project-create','project-delete'])
          <li><a href="{!!route('projectList')!!}">Projects list</a></li>
          @endpermission
          @permission(['activity-view','activity-edit','activity-create','activity-delete'])
          <li><a href="{!!route('activityList')!!}">Activity list</a></li>
          @endpermission
        </ul>
      </li>
    </ul>
    @endpermission

      @permission(['dashboard-view'])
      <ul class="nav side-menu">
        <li><a><i class="fa fa-bar-chart-o"></i>Dashboard<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @permission(['dashboard-view'])
            <li><a href="{!!route('dashboardLoad')!!}">Users load</a></li>
            <li><a href="{!!route('dashboardLoadChart')!!}">Users load Chart</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
      @endpermission

      @permission(['tools-activity-view'])
      <ul class="nav side-menu">
        <li><a><i class="fa fa-desktop"></i>Tools<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            @permission(['tools-activity-view'])
            <li><a href="{!!route('toolsActivities')!!}">Activity list per project</a></li>
            <li><a href="{!!route('projectsAssignedAndNot')!!}">Project assignment</a></li>
            @endpermission
          </ul>
        </li>
      </ul>
      @endpermission

  </div>
</div>
