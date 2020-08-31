@extends('ticket::layouts.index')
@section('title','Tickets Index Page')
@section('content')
<style>
    /* .tox-tinymce {
        height: 300px !important;

    } */

    .kt-inbox__text>p>img {
        width: 100px !important;
    }

    .badge-notify {
        position: relative;
        top: -20px;
        left: -35px;
    }
</style>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
                    Tickets
                </h3>

                <!-- BreadCrumbs-->
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{route('dashboard')}}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>

                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <!-- <a href="" class="kt-subheader__breadcrumbs-link">
                                Classic </a> -->

                    <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Tickets</span>
                </div>
                <!-- BreadCrumsbs end -->
            </div>

        </div>
    </div>

    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Inbox-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver-desktop  kt-inbox" id="kt_inbox">

            <!--Begin::Aside Mobile Toggle-->
            <button class="kt-inbox__aside-close" id="kt_inbox_aside_close">
                <i class="la la-close"></i>
            </button>

            <!--End:: Aside Mobile Toggle-->

            <!--Begin:: Inbox Aside-->
            @include('ticket::partials.tickets.ticket_sidebar')
            <!--End::Aside-->

            <!--Begin:: Inbox List-->
            @include('ticket::partials.tickets.ticket_list')
            <!--End:: Inbox List-->


            <!--Begin:: Inbox View-->
            @include('ticket::partials.tickets.ticket_inbox')
            <!--End:: Inbox View-->
        </div>

        <!--End::Inbox-->

        <!--Begin:: Model-->
        {{-- Modal --}}
        <div class="modal fade" id="kt_create_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form class="kt-form kt-form--label-right" action="{{route('tickets.store')}}" method="post" id="kt_form_ticket">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group form-group-last row">

                                <div class="col-lg-12 form-group-sub">
                                    <label class="form-control-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Enter Subject" maxlength="100" required>
                                </div>
                            </div>
                            <div class="form-group form-group-last row">
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Type</label>
                                    <select class="form-control kt-selectpicker" name="type_id" data-live-search="true" required>
                                        <option value="0">Question</option>
                                        <option value="1">Incident</option>
                                        <option value="2">Problem</option>
                                        <option value="3">Task</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group-sub">
                                    <label class="form-control-label">Priority</label>
                                    <select class="form-control kt-selectpicker" name="priority" data-live-search="true" required>
                                        <option value="0">Low</option>
                                        <option value="1">Normal</option>
                                        <option value="2">High</option>
                                        <option value="3">Urgent</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group form-group-last row  mt-4">
                                <div class="col-lg-12 form-group-sub">
                                    <textarea name="message" id="kt-ticket-store-tinymce" class="tox-target" rows="2"></textarea>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="kt-form__actions">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>

{{-- Modal for edit Ticket --}}
<div class="modal fade" id="ticket_edit_modal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{route('tickets.update')}}" method="POST" id="kt_form_edit_ticket">
                @csrf
                <div class="modal-body">
                    <div class="form-group form-group-last row">
                        <input type="hidden" name="ticketId" id="ticketId">
                        <div class="col-lg-12 form-group-sub">
                            <label class="form-control-label">Subject</label>
                            <input type="text" name="subject" id="ticketSubject" class="form-control" placeholder="Enter Subject" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-group form-group-last row">
                        <div class="col-lg-6 form-group-sub">
                            <label class="form-control-label">Type</label>
                            <select class="form-control kt-selectpicker" name="type_id" id="ticketType_id" data-live-search="true" required>
                                <option value="0">Question</option>
                                <option value="1">Incident</option>
                                <option value="2">Problem</option>
                                <option value="3">Task</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group-sub">
                            <label class="form-control-label">Priority</label>
                            <select class="form-control kt-selectpicker" name="priority" id="ticketPriority" data-live-search="true" required>
                                <option value="0">Low</option>
                                <option value="1">Normal</option>
                                <option value="2">High</option>
                                <option value="3">Urgent</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="kt-form__actions">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    tinymce.init({
        selector: '#kt-ticket-reply-tinymce',
        height: 400,
        paste_data_images: true,
        toolbar: 'undo redo | formatselect | bold italic backcolor| link image| \
                     alignleft aligncenter alignright alignjustify | \
                     bullist numlist outdent indent | removeformat | help | image code | paste',
        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
        images_upload_url: '/tickets/store_replies_image',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/tickets/store_replies_image');
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });

    tinymce.init({
        selector: '#kt-ticket-store-tinymce',
        height: 400,
        paste_data_images: true,
        toolbar: 'undo redo | formatselect | bold italic backcolor| link image| \
                     alignleft aligncenter alignright alignjustify | \
                     bullist numlist outdent indent | removeformat | help | image code | paste',

        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',


        images_upload_url: '/tickets/store_replies_image',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/tickets/store_replies_image');
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });

    $("#kt_form_edit_ticket").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(ticket) {

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success("Updated Successfully");


                getReplies(ticket.id);

                var modal = $('#ticket_edit_modal');
                modal.find("#ticketId").val(ticket.id);
                modal.find("#ticketSubject").val(ticket.subject);
                modal.find('#ticketType_id option[value="' + ticket.type_id + '"]').attr('selected', 'selected');
                modal.find('#ticketPriority option[value="' + ticket.priority + '"]').attr('selected', 'selected');
                $('.kt-selectpicker').selectpicker('refresh');


                $('#ticket_edit_modal').modal('toggle');

            }
        });


    });

    $("#submit_reply").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        tinyMCE.triggerSave();
        var form = $(this);
        console.log(form.serialize());
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(ticket) {
                $("#submit_reply").get(0).reset();
                getReplies(ticket.ticket_id);

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success("Your Reply Saved Successfully");

            }
        });


    });

    function getReplies(ticketId) {

        const url = '/tickets/get_replies/' + ticketId;
        $.ajax({
            url: url,
            success: function(replies) {

                var modal = $('#ticket_edit_modal');
                modal.find("#ticketId").val(replies.allReplies[0].ticket.id);
                modal.find("#ticketSubject").val(replies.allReplies[0].ticket.subject);
                modal.find('#ticketType_id option[value="' + replies.allReplies[0].ticket.type_id + '"]').attr('selected', 'selected');
                modal.find('#ticketPriority option[value="' + replies.allReplies[0].ticket.priority + '"]').attr('selected', 'selected');
                $('.kt-selectpicker').selectpicker('refresh');


                $('#subject').html(replies.allReplies[0].ticket.subject);
                $('#type_id').html(getType(replies.allReplies[0].ticket.type_id));
                if (getPriority(replies.allReplies[0].ticket.priority) == "Low") {
                    $('#priority').html(`<span class="kt-inbox__label kt-badge--unified-success kt-badge kt-badge--bold kt-badge--inline ml-2">${getPriority(replies.allReplies[0].ticket.priority)}</span>`);
                } else if (getPriority(replies.allReplies[0].ticket.priority) == "Normal") {
                    $('#priority').html(`<span class="kt-inbox__label kt-badge--unified-warning kt-badge kt-badge--bold kt-badge--inline ml-2">${getPriority(replies.allReplies[0].ticket.priority)}</span>`);
                } else {
                    $('#priority').html(`<span class="kt-inbox__label kt-badge--unified-danger kt-badge kt-badge--bold kt-badge--inline ml-2">${getPriority(replies.allReplies[0].ticket.priority)}</span>`);
                }

                $('#submit_reply').attr('action', '/tickets/store_reply/' + replies.allReplies[0].ticket.id);
                $('#message_box').empty();
                $.each(replies.allReplies, function(index, reply) {


                    if (reply.replied_by === 'agent') {
                        var name = reply.agent_name + "( Agent ID: " + reply.user_id + " )";
                    } else {

                        var name = replies.userName;

                    }
                    $('#message_box').append(`<div class="kt-inbox__messages" style="background-color: #F7F8FC;">
                                        <div class="kt-inbox__message kt-inbox__message--expanded">
                                            <div class="kt-inbox__head">

                                                <div class="kt-inbox__info">
                                                    <div class="kt-inbox__author" data-toggle="expand">
                                                        <a href="#" class="kt-inbox__name">  ${name}  </a>

                                                    </div>

                                                </div>
                                                <div class="kt-inbox__actions">
                                                        <div class="kt-inbox__datetime" data-toggle="expand">

                                                    ${new Date(reply.created_at).toDateString()}
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="kt-inbox__body">
                                                <div class="kt-inbox__text">
                                                    <p class="kt-margin-t-25"> ${reply.message}  </p>

                                                </div>
                                            </div>
                                        </div>

                        </div>`);

                });
            }
        });
    }



    function getType(type) {
        if (type == 0) {
            return "Question";
        }
        if (type == 1) {
            return "Incident";
        }
        if (type == 2) {
            return "Problem";
        }
        if (type == 3) {
            return "Task";
        }
    }

    function getPriority(priority) {
        if (priority == 0) {
            return "Low";
        }
        if (priority == 1) {
            return "Normal";
        }
        if (priority == 2) {
            return "High";
        }
        if (priority == 3) {
            return "Urgent";
        }
    }


    $(document).ready(function() {
        $(".kt-nav__item").click(function() {
            $(".kt-nav__item").removeClass("kt-nav__item--active");
            // $(".tab").addClass("active"); // instead of this do the below
            $(this).addClass("kt-nav__item--active");
        });
    });

    $(document).ready(function() {
        $("#kt_form_ticket").validate({});
        $("#kt_form_edit_ticket").validate({});
    });

    $("#goToReply").click(function() {
        $('html,body').animate({
                scrollTop: $("#replyDiv").offset().top
            },
            'slow');
    });
</script>

@endsection