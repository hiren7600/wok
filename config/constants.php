<?php

return [


    // website related constants
    'cachecounter'                            => 0.0,
    'company'                                => 'World of Kink',
    'website'                                => 'World of Kink',
    'adminemail'                            => 'postal@worldofkink.com',
    'adminetomail'                          => 'support@professionalidiots.com',
    'adminname'                             => 'World of Kink',
    'perpage'                                => 20,
    'verification_time'                     => 60,   //in minutes

    // date related data
    'dateformat_listing_datetime'            => 'M d, Y h:i A',
    'dateformat_listing_date'                => 'M d, Y',
    'dateformat_store_datetime'                => 'Y-m-d H:i:s',
    'dateformat_store_date'                    => 'Y-m-d',

    // images related data
    'dir_thumb'                                => 'thumb/',
    'dir_original'                            => 'original/',

    // user related data
    'path_user'                                => '/data/users/',
    'user_image_width'                         => 500,
    'user_image_height'                        => 500,

    'user_thumb_image_width'                   => 100,
    'user_thumb_image_height'                  => 100,
    
    'user_small_thumb_image_width'             => 75,
    'user_small_thumb_image_height'            => 75,
    'user_medium_thumb_image_width'            => 150,
    'user_medium_thumb_image_height'           => 150,
    'user_large_thumb_image_width'             => 300,
    'user_large_thumb_image_height'            => 300,
    
    'dir_media'                                => '/data/media/',

    'feed_image_width'                         => 735,
    'feed_comment_image_width'                 => 635,

    'gender' => [
        'M' => 'Male',
        'F' => 'Female',
        'Couple' => 'Couple',
        'TG' => 'Transgender',
        'MtF' => 'Trans - Male to Female',
        'FtM' => 'Trans - Female to Male',
        'CD/TV' => 'Crossdresser/Transvestite',
        'NB' => 'Non-Binary',
        'GQ' => 'Genderqueer',
        'GF' => 'Gender Fluid',
        'IN' => 'Intersex',
        'FB' => 'Femme',
        'BC' => 'Butch',
    ],
    'relationships' => [
        "Single" => "Single",
        "Dating" => "Dating",
        "Engaged" => "Engaged",
        "Friends With Benefits" => "Friends With Benefits",
        "In an Open Relationship" => "In an Open Relationship",
        "It's Complicated" => "It's Complicated",
        "Lover" => "Lover",
        "Married" => "Married",
        "Monogamous" => "Monogamous",
        "Partner" => "Partner",
        "Play Partners" => "Play Partners",
        "Polyamorous" => "Polyamorous",
        "Primary" => "Primary",
        "Widowed" => "Widowed",
        "Wishing I was Widowed" => "Wishing I was Widowed",
    ],
    'orientations' => [
        'Straight' => 'Straight',
        'Bisexual' => 'Bisexual',
        'Bi-Curious' => 'Bi-Curious',
        'Gay' => 'Gay',
        'Lesbian' => 'Lesbian',
        'Demisexuality' => 'Demisexuality',
        'Dyke' => 'Dyke',
        'Fluctuating/Evolving' => 'Fluctuating/Evolving',
        'Heteroflexible' => 'Heteroflexible',
        'Homoflexible' => 'Homoflexible',
        'Pansexual' => 'Pansexual',
        'Queer' => 'Queer',
        'Situational Sexuality' => 'Situational Sexuality',
        'Unsure' => 'Unsure',
    ],
    'role' => [
        'Babygirl' => 'Babygirl',
        'Bottom' => 'Bottom',
        'Caregiver' => 'Caregiver',
        'Cuckold' => 'Cuckold',
        'Cuckqueen' => 'Cuckqueen',
        'Daddy' => 'Daddy',
        'Disciplinarian' => 'Disciplinarian',
        'Dominant' => 'Dominant',
        'Domme' => 'Domme',
        'Drag ' => 'Drag ',
        'Exhibitionist' => 'Exhibitionist',
        'Feminizer' => 'Feminizer',
        'Furry' => 'Furry',
        'Kinkster' => 'Kinkster',
        'Kitten' => 'Kitten',
        'Masochist' => 'Masochist',
        'Master' => 'Master',
        'Mistress' => 'Mistress',
        'Mommy' => 'Mommy',
        'Pet' => 'Pet',
        'Pony' => 'Pony',
        'Pup' => 'Pup',
        'Sadist' => 'Sadist',
        'Sadomasochist' => 'Sadomasochist',
        'Sensualist' => 'Sensualist',
        'Sissy' => 'Sissy',
        'Slave' => 'Slave',
        'Submissive' => 'Submissive',
        'Swinger' => 'Swinger',
        'Switch' => 'Switch',
        'Top' => 'Top',
        'Voyeur' => 'Voyeur',
    ],

    'looking_for' => [
        'Women' => 'Women',
        'Men' => 'Men',
        'Couples' => 'Couples',
        'TV/TS' => 'TV/TS',
        'Cross Dresser' => 'Cross Dresser',
        'Online Only' => 'Online Only',
    ],

    'page' => [
        'feed' => 'Feed',
        'exposed' => 'Exposed',
        'location' => 'Location',
        'group' => 'Group',
        'videos' => 'Videos',
        'kink' => 'Kink',
        'conversation' => 'Conversation',
        'friend-request' => 'Friend Request',
        'notification' => 'Notification',
        'profile' => 'Profile',
        'about-me' => 'About Me',
        'filters' => 'Filters',
        'upload-photo' => 'Upload Photo',
        'upload-videos' => 'Upload videos',
        'settings' => 'Settings',
        'notification-list' => 'Notification List',
        'user-images' => 'User Images',
        'image-detail' => 'Image Detail',
        'user-videos' => 'User Videos',
        'video-detail' => 'Video Detail',
        'home' => 'Home',
        'signup' => 'Signup',
        'login' => 'Login',
        'forgot-password' => 'Forgot Password',
        'reset-password' => 'Reset Password',
        'contact-us' => 'Contact Us',
        'dmca' => 'DMCA',
        'privacy-policy' => 'Privacy Policy',
        'terms' => 'Terms of Services',
        'posting-guidelines' => 'Posting Guidelines',
        '2257' => '2257',
    ],


];
