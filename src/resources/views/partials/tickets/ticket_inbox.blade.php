<div class="kt-grid__item kt-grid__item--fluid  kt-inbox__view kt-inbox__view--shown-" id="kt_inbox_view">
    <div class="kt-portlet">


        <div class="kt-portlet__head">
            <div class="kt-inbox__toolbar">
                <div class="kt-inbox__actions" style="width: 80%;">
                    <a href="/{{Request::path()}}" class="kt-inbox__icon kt-inbox__icon--back">
                        <i class="flaticon2-left-arrow-1"></i>
                    </a>


                    <h4 class="kt-inbox__text" id="subject" style="word-wrap: break-word;width: 90%;">
                    </h4>

                    <span class="kt-inbox__summary" id="type_id"></span>

                    <div id="priority">
                    </div>

                </div>
                @if(Request::segment(2) != 'suspended')
                <div class="kt-inbox__controls">
                    <a class="btn btn-label-brand btn-bold btn-sm mr-2" href="#" data-toggle="modal" data-target="#ticket_edit_modal"> <i class="kt-nav__link-icon flaticon2-contract"></i> <span class="kt-nav__link-text">Edit</span> </a>
                    <button type="button" class="btn btn-success btn-sm " id="goToReply"><i class="fa fa-reply"></i> Reply</button>
                </div>
                @endif
            </div>
        </div>

        <!-- All Replies -->

        <div class="kt-portlet__body" id="message_box">
        </div>


        <!-- Text Editor -->
        @if(Request::segment(2) != 'suspended')
        <div class="kt-portlet__body" id="replyDiv">
            <div class="kt-inbox__messages">
                <form class="kt-form kt-form--label-right" method="post" id="submit_reply">
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="replied_by" value="user">
                    <div class="kt-inbox__message kt-inbox__message--expanded">
                        <div class="kt-inbox__head">

                            <div class="kt-inbox__info">
                                <div class="kt-inbox__author" data-toggle="expand">
                                    <span class="kt-inbox__name">Reply</span>

                                </div>

                            </div>

                        </div>
                        <div class="kt-inbox__body">

                            <textarea name="message" id="kt-ticket-reply-tinymce" class="tox-target" rows="2"></textarea>

                        </div>

                        <div class="kt-inbox__foot">
                            <div class="kt-inbox__primary">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-brand btn-bold">
                                        Send
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="kt-portlet__body">
            <div class="kt-inbox__messages">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-cancel"></i></div>
                    <div class="alert-text">This Ticket Is Suspended!</div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>