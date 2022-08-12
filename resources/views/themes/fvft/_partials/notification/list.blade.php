<?php $user = Auth::user(); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Notifications') }}</h3>
        <div class="card-options">
            <a href="{{ route('site.read-notifications', ['type' => 'unread', 'id' => 0]) }}" class="btn btn-sm btn-primary mr-2"><i class="fa fa-check mr-1"></i> Mark all as read</a>
            {{--$user->unreadNotifications->markAsRead();--}}
        </div>
    </div>
    <div class="card-body">
        <div class="card-pay">
            <ul class="tabs-menu nav">
                <li class=""><a href="#tab1" class="active" data-toggle="tab"> All Notifications</a></li>
                <li><a href="#tab2" data-toggle="tab" class=""> Unread Notifications</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="tab1">
                    @if(!blank($user->notifications))
                        @foreach ($user->notifications as $notification)
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="{{ blank($notification->read_at) ? '' : 'bg-secondary' }} p-4">
                                        <label class="form-label">
                                            {{ class_basename($notification->type) }}
                                            @if(blank($notification->read_at))
                                                <a href="{{ route('site.read-notifications', ['type' => 'single', 'id' => $notification->id]) }}"
                                                   class="ml-4"><i class="mr-1 fa fa-check"></i>Mark as read</a>
                                            @else
                                                <small class="text-primary ml-4">Read on {{ $notification->read_at }}</small>
                                            @endif
                                        </label>
                                        <ul class="list-unstyled widget-spec mb-0">
                                            <li class="">
                                                <i class="fa fa-caret-right {{ blank($notification->read_at) ? 'text-danger' : 'text-primary' }}" aria-hidden="true"></i>
                                                {{ array_key_exists('subject', $notification->data) ? $notification->data['subject'] : $notification->data['msg']}}
                                                @if(isset($notification->data['link']) AND !blank($notification->data['link']))
                                                    <a href="{{ $notification->data['link'] }}" class="ml-4">View</a>
                                                @endif
                                            </li>
                                            <li class="">

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row mb-1">
                            <div class="col-md-12">
                                You don't have any notifications.
                            </div>
                        </div>
                    @endif
                </div>

                <div class="tab-pane" id="tab2">
                    @if(!blank($user->unreadNotifications))
                        @foreach ($user->unreadNotifications as $unreadNotification)
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="{{ blank($unreadNotification->read_at) ? 'bg-secondary' : '' }} p-4">
                                        <label class="form-label">
                                            {{ class_basename($unreadNotification->type) }}
                                            @if(blank($unreadNotification->read_at))
                                                <a href="{{ route('site.read-notifications', ['type' => 'single', 'id' => $unreadNotification->id]) }}"
                                                   class="ml-4"><i class="mr-1 fa fa-check"></i>Mark as read</a>
                                            @else
                                                <small class="text-primary ml-4">Read on {{ $unreadNotification->read_at }}</small>
                                            @endif
                                        </label>
                                        <ul class="list-unstyled widget-spec mb-0">
                                            <li class="">
                                                <i class="fa fa-caret-right text-danger" aria-hidden="true"></i>
                                                {{ array_key_exists('subject', $notification->data) ? $notification->data['subject'] : $notification->data['msg']}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row mb-1">
                            <div class="col-md-12">
                                You don't have any notifications.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
