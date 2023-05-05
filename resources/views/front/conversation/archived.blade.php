@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>User EMail</title>
    @endif
@endsection


@section('content')
    <section class="mail-page">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-12">
                    <div class="lime-body mailbox">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="inbox-heading">Inbox</h1>
                                <div class="mailbox-inner-box">
                                    <div class="mailbox-menu">
                                        <ul class="mailmenu-list-unstyled">
                                            <li><a href="{{ url('/conversation') }}">Inbox <span
                                                        class="mail-index">(99+)</span></a>
                                            </li>
                                            <li><a href="{{ url('/conversation-sent') }}">Sent</a></li>
                                            <li><a href="{{ url('/conversation-archived') }}" class="active">Archived</a></li>
                                        </ul>
                                    </div>
                                    <div class="mail-list-container">

                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                Ipsam repellendus repudiandae possimus, animi,
                                                                temporibus excepturi neque modi id ducimus non
                                                                doloremque optio dolorum, pariatur error tempora ipsa
                                                                nobis distinctio culpa?
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing
                                                                elit. Illo libero doloribus dicta maiores nisi deserunt
                                                                vel placeat vero error incidunt unde, adipisci
                                                                voluptatibus esse commodi. Incidunt, exercitationem
                                                                commodi. Labore, voluptatum!
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items unread">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/profile-img.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mail-info">
                                            <div class="mail-list-items ">
                                                <div class="mail-author-info">
                                                    <img src="{{ asset_front('/images/no-image-icon.png') }}"
                                                        alt="mail author image" class="mail-author-image">
                                                    <a href="#">
                                                        <span class="mail-author-name">
                                                            Jaylooking420
                                                        </span>
                                                        <span>52M</span>
                                                        <p>Denver, Colorado</p>
                                                        <div class="archive-items">
                                                            <span>Aug 18, 2022</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="message-info">
                                                    <a href="#">
                                                        <div class="subject-text">Can I try </div>
                                                        <div class="message-text">
                                                            <p>
                                                                Lorem ipsum dolor sit amet
                                                                consectetur adipisicing elit. Possimus, molestias.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="controler-menu">

                                                    <button class="delete-mail-box"><span
                                                            class="dsk-for">Delete</span></button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
@endsection
