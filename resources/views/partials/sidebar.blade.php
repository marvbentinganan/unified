<div class="ui large left blue inverted vertical accordion sidebar menu">
    <a class="header item">
        Home
        <i class="home icon"></i>
    </a>
    <div class="item">
        <div class="active title">
            Build Files
            <i class="dropdown icon"></i>
        </div>
        <div class="active content">
            <div class="menu">
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Departments
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Groups
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Roles
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Parameters
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Permisions
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Subjects
                </a>
                <a href="" class="item">
                    <i class="ion-edit icon"></i>
                    Types
                </a>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="title">
            Faculty Evaluation
            <i class="dropdown icon"></i>
        </div>
        <div class="content">
            <div class="menu">
                <a href="" class="item">
                    <i class="ion-speedometer icon"></i>
                    Dashboard
                </a>
                <a href="" class="item">
                    <i class="ion-podium icon"></i>
                    Evaluations
                </a>
                <a href="" class="item">
                    <i class="search icon"></i>
                    Search
                </a>
                <a href="" class="item">
                    <i class="ion-person-stalker icon"></i>
                    Instructors
                </a>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="title">
            UniFi Monitoring
            <i class="dropdown icon"></i>
        </div>
        <div class="content">
            <div class="menu">
                <a href="" class="item">
                    <i class="ion-speedometer icon"></i>
                    Dashboard
                </a>
                <a href="" class="item">
                    <i class="ion-clipboard icon"></i>
                    Access Logs
                </a>
                <a href="" class="item">
                    <i class="search icon"></i>
                    Search
                </a>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="title">
            User Management
            <i class="dropdown icon"></i>
        </div>
        <div class="content">
            <div class="menu">
                <a href="" class="item">
                    <i class="ion-ios-person icon"></i>
                    Staff
                </a>
                <a href="" class="item">
                    <i class="ion-person icon"></i>
                    Faculty
                </a>
                <a href="" class="item">
                    <i class="ion-university icon"></i>
                    Students
                </a>
                <a href="" class="item">
                    <i class="ion-ios-people icon"></i>
                    Active Directory
                </a>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="title">
            Settings
            <i class="dropdown icon"></i>
        </div>
        <div class="content">
            <div class="menu">
                <a href="" class="item">
                    <i class="ion-gear-a icon"></i>
                    Account Settings
                </a>
                <a href="" class="item">
                    <i class="ion-gear-b icon"></i>
                    Global Settings
                </a>
            </div>
        </div>
    </div>
    <a class="item" onclick="confirm()">
        Sign Out
        <i class="ion-log-out icon"></i>
    </a>
</div>

@push('footer_scripts')
<script>
    $('.accordion').accordion();

</script>



@endpush
