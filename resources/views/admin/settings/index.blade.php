@extends('layouts.admin')

@section('title', 'System Settings')
@section('page-title', 'Settings')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-cogs fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">System Settings</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Configure core application parameters, API keys, and preferences.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="nav flex-column nav-pills bg-white rounded border  p-2" id="settings-tab" role="tablist" aria-orientation="vertical">
            @php
                // Use grouped settings from controller or fallback
                $groupedSettings = isset($settings) && $settings->isNotEmpty() ? $settings : collect([
                    'general' => collect([ (object)['key'=>'site_name', 'label'=>'Site Name', 'value'=>'Booking App'], (object)['key'=>'support_email', 'label'=>'Support Email', 'value'=>'support@example.com'] ]),
                    'payment' => collect([ (object)['key'=>'stripe_key', 'label'=>'Stripe Public Key', 'value'=>''], (object)['key'=>'stripe_secret', 'label'=>'Stripe Secret', 'value'=>''] ]),
                    'social' => collect([ (object)['key'=>'fb_link', 'label'=>'Facebook Link', 'value'=>''] ])
                ]);
            @endphp
            
            @foreach($groupedSettings as $group => $items)
                <button class="nav-link {{ $loop->first ? 'active' : '' }} text-start  mb-1" 
                        id="tab-{{ Str::slug($group) }}" 
                        data-bs-toggle="pill" 
                        data-bs-target="#pane-{{ Str::slug($group) }}" 
                        type="button" role="tab" 
                        aria-controls="pane-{{ Str::slug($group) }}" 
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    <i class="fas fa-circle me-2" style="font-size: 8px;"></i> {{ ucfirst($group) }}
                </button>
            @endforeach
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card bg-white  shadow-sm">
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="tab-content" id="settings-tabContent">
                        @foreach($groupedSettings as $group => $items)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="pane-{{ Str::slug($group) }}" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-{{ Str::slug($group) }}">
                                
                                <h5 class=" mb-4 border-bottom  pb-2">{{ ucfirst($group) }} Settings</h5>
                                
                                @foreach($items as $setting)
                                    <div class="mb-3 row">
                                        <label for="setting_{{ $setting->key ?? '' }}" class="col-sm-3 col-form-label ">{{ $setting->label ?? ucfirst(str_replace('_', ' ', $setting->key ?? '')) }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" 
                                                   class="form-control bg-white  " 
                                                   id="setting_{{ $setting->key ?? '' }}" 
                                                   name="settings[{{ $setting->key ?? '' }}]" 
                                                   value="{{ $setting->value ?? '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-3 border-top  text-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
