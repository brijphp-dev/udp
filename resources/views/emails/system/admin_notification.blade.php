@include('emails.header')

<!-- Email Body : BEGIN -->
<table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;" class="email-container">


    <!-- Email Body : BEGIN -->

    <tr>
        <td bgcolor="#ffffff">
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td style="padding:20px 40px 40px 40px; text-align: left;  font-family:'Poppins', -apple-system, BlinkMacSystemFont, Helvetica, Arial, sans-serif; color:#2e343b; font-size:13.5px; font-weight:300; letter-spacing:0.07em; line-height:2em;">
                            <strong>Hello {{ $user->first_name }},</strong>
                            <br><br>
                            {!! $content !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <!-- Email Body : END -->
    @include('emails.footer')
                        

</table>

<!-- Email Body : END -->

@include('emails.footer')

