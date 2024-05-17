<div class="card-header">
    <h3 class="card-title">Папки</h3>
</div>
<div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item active">
            <a href="{{ route($roleData['roleData']['emails_index']) }}" class="nav-link">
                <i class="fas fa-inbox"></i> Вхiднi
                @if($count > 0)
                    <span class="badge bg-primary float-right">{{$count}}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route($roleData['roleData']['emails_send_emails']) }}" class="nav-link">
                <i class="far fa-envelope"></i> Вiдправленi
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route($roleData['roleData']['emails_deleted_emails']) }}" class="nav-link">
                <i class="far fa-trash-alt"></i> Видаленi
                @if($deleteCount > 0)
                    <span class="badge bg-danger float-right">{{$deleteCount}}</span>
                @endif
            </a>
        </li>
    </ul>
</div>
