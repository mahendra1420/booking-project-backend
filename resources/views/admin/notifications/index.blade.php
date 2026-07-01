@extends('layouts.admin')

@section('title', 'Push Notifications')
@section('page-title', 'Push Notifications')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-bell fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Push Notifications</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Broadcast notifications to users and barbers.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card bg-white  shadow-sm">
            <div class="card-header  ">
                <h5 class="mb-0"><i class="fas fa-paper-plane me-2"></i> Send New Notification</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="target" class="form-label ">Target Audience</label>
                        <select class="form-select bg-white  " id="target" name="target">
                            <option value="all">All Users & Barbers</option>
                            <option value="users">All Customers</option>
                            <option value="barbers">All Barbers</option>
                            <option value="specific">Specific User(s)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label ">Notification Title</label>
                        <input type="text" class="form-control bg-white  " id="title" name="title" placeholder="Enter title (e.g. Flash Sale!)" required>
                    </div>

                    <div class="mb-4">
                        <label for="body" class="form-label ">Message Body</label>
                        <textarea class="form-control bg-white  " id="body" name="body" rows="4" placeholder="Enter notification message..." required></textarea>
                        <div class="form-text" style="color: var(--admin-text-muted);">Keep it short and engaging.</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Clear</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Broadcast Notification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
