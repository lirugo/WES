<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'homework' => [
            'driver' => 'local',
            'root' => storage_path('app/group/homework/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'library' => [
            'driver' => 'local',
            'root' => storage_path('app/library/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'pretest' => [
            'driver' => 'local',
            'root' => storage_path('app/pretest/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'material' => [
            'driver' => 'local',
            'root' => storage_path('app'.DIRECTORY_SEPARATOR.'material'.DIRECTORY_SEPARATOR),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'video-lesson' => [
            'driver' => 'local',
            'root' => storage_path('app'.DIRECTORY_SEPARATOR.'video-lesson'.DIRECTORY_SEPARATOR),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'activity' => [
            'driver' => 'local',
            'root' => storage_path('app/activity/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'group-work' => [
            'driver' => 'local',
            'root' => storage_path('app/group-work/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'common-file' => [
            'driver' => 'local',
            'root' => storage_path('app/common/file/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        'user-file' => [
            'driver' => 'local',
            'root' => storage_path('app/user/file/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

];
