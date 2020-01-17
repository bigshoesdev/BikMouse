@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @lang('general/message.bikmouse')
        @endcomponent
    @endslot
    @lang('general/message.send_code_message_body')
    <h2>{!! $data->code !!}</h2>
    @slot('footer')
        @component('mail::footer')
            @lang('general/message.send_code_message_footer')
        @endcomponent
    @endslot
@endcomponent