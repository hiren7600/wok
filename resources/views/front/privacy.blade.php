@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Privacy Policy</title>
    @endif
@endsection

@section('content')
    <section class="content-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm col-md-9 col-lg-8 col-xxl-7">
                    <div class="content-area">
                        <h3>Privacy Policy</h3>
                        <p>worldofkink.com and its affiliates (collectively, the “Site”) respect your privacy. Here is our
                            Privacy Policy for this Site:</p>
                        <span>Acceptance of Privacy Policy</span>
                        <p>Each time you access, use, post, submit a post or reply, or browse the Site, you signify your
                            acceptance of the then-current Privacy Policy. If you do not accept this Privacy Policy, you are
                            not authorized to use the Site and must discontinue use of the Site immediately.</p>
                        <span>Collection and Use of Personal Information</span>
                        <p>We collect personal information about you whenever you engage in commerce transactions on the
                            Site, use the Site’s products or services, request information or materials, create or update
                            account information, place orders or make purchases, communicate with us, or visit the Site. The
                            personal information we collect and store about you may include without limitation your first
                            and last name, email address, credit or debit card number, telephone numbers, billing and
                            shipping information, order history, and other non-public information about you.
                        </p>
                        <p>We may use the information we collect to:</p>
                        <ul>
                            <li>Provide superior services;</li>
                            <li>Keep you apprised of information and developments that you may find of interest;</li>
                            <li>Alert you to new features, terms, content, products or services;</li>
                            <li>Contact you regarding your posts, replies, and/or account information;</li>
                            <li>Process and respond to your inquiries;</li>
                            <li>Improve the Site;</li>
                            <li>Administer, monitor and control use of the Site, including posts, replies, and account
                                information; and</li>
                            <li>Enforce the <a href="#">Terms of Use</a> (collectively, the “Activities”).</li>
                        </ul>
                        <p>You authorize the Site to transmit email to you to respond to your communications and administer
                            Activities. If you choose to receive mobile notifications, you authorize and agree that the Site
                            may send text messages to your mobile phone. You will be responsible for any message or data
                            charges that may apply.</p>
                        <span>Disclosure of Personal Information to Third Parties</span>
                        <p>We may disclose your personal information to agents and operators under confidentiality or
                            similar agreements, including shippers, vendors, payment processors, and advertisers, who we
                            believe reasonably need to come into contact with that information: (i) to provide products or
                            services to you; (ii) to administer our business or the Site, including fulfilling and shipping
                            orders; (iii) to provide customer service; (iv) to update account information; (v) to forward
                            updates, announcements, and newsletters; (vi) to respond to your communications, and communicate
                            with you about the Site and other activities related to the Site; (vii) in the event of any
                            reorganization, merger, sale, joint venture, assignment, transfer or disposition of all or any
                            portion of the Site’s business or operations (including without limitation in connection with a
                            bankruptcy or any similar proceedings); or (viii) as otherwise authorized by you.</p>
                        <span>Disclosure in Other Circumstances</span>
                        <p>We may also disclose your name, email address, telephone numbers, or other information about you,
                            including personal information if (i) required to do so by law, court order or subpoena, or as
                            requested by other government, law enforcement, or investigative authority, (ii) we in good
                            faith believe that such disclosure is necessary or advisable, including without limitation to
                            protect the rights or properties of the Site, (iii) we have reason to believe that disclosing
                            your personal information is necessary to identify, contact or bring legal action against
                            someone who may be causing interference with our rights or properties, or has breached an
                            agreement, or if anyone else could be harmed by such activities or interference, (iv) if we
                            determine an ad posted violates our Terms of Use or the rights of a third party, or (v) there is
                            an emergency involving personal danger. We may also provide information about you if we believe
                            it is necessary to share information in order to investigate, prevent or take action regarding
                            illegal activities, suspected fraud, situations involving potential threats to the physical
                            safety of any person, or as otherwise required or permitted by law.</p>
                        <p>Please note that if you post any of your personal information on the Site, such information may
                            be collected and used by others over whom the Site has no control. The Site is not responsible
                            for the use by third parties of information you post or otherwise make public.</p>
                        <span>Collection of Non-Personal Information Using Cookies</span>
                        <p>We and certain service providers operating on our behalf collect information about your activity
                            on our Site using tracking technologies such as cookies. This tracking data is used for many
                            purposes, including, for example, to (i) deliver relevant content based on your preferences,
                            usage patterns and location; (ii) monitor and evaluate the use and operation of our Site; and
                            (iii) analyze traffic on our Site and on the sites of third parties.</p>
                        <p>Non-personal information collected includes, without limitation, your Internet Protocol (“IP”)
                            address, the pages you request, the type of computer operating system you use (e.g., Microsoft
                            Windows or Mac OS), the type of browser you use (e.g., Firefox, Chrome or Internet Explorer),
                            the domain name of the Internet service provider, your activities while visiting the Site and
                            the content you accessed. We may also collect your geolocation information when you visit our
                            Site, including location information either provided by a mobile device interacting with our
                            Site, or associated with your IP address, where we are permitted by law to process this
                            information.</p>
                        <p>Advertisers and third parties also may collect information about your activity on our Site and on
                            third-party sites and applications using tracking technologies. Tracking data collected by these
                            advertisers and third parties is used to decide which ads you see on third-party sites and
                            applications, but does not identify you personally. You may choose not to receive targeted
                            advertising from many ad networks, data exchanges, marketing analytics and other service
                            providers. You may also choose to control targeted advertising you receive within applications
                            by using your mobile device settings (for example, by re-setting your device’s advertising
                            identifier and/or opting out of interest based ads). We adhere to the Digital Advertising
                            Alliance’s Self-Regulatory Principles for Online Behavioral Advertising.</p>
                        <span>Communication from the Site/Opt-Out</span>
                        <p>From time to time, we may send you information with announcements and updates about the Site and
                            your account. You may elect to opt-out of ongoing e-mail communication from us, such as
                            newsletters, subscriptions, account information, promotional materials, contest results, survey
                            inquiries, etc. by using a simple “opt out” procedure. You need only reply to the communication
                            with the word “unsubscribe” (without the quotation marks) in the body of your e-mail response
                            and your name will be removed from that mailing list. However, if you opt-out of receiving our
                            announcements and updates about your account, you may no longer have access to areas restricted
                            to account members.</p>
                        <span>Correction/Update of Personal Information</span>
                        <p>If your personal information changes, you may review/correct/update your personal information
                            previously provided at any time by sending us an email at support@worldofkink.com. You may also
                            have your personal profile data deleted from our database by sending us an email to
                            support@worldofkink.com. However, if you have your personal profile data deleted from our
                            database, you may forfeit entrance rights to areas restricted to account members and certain
                            benefits for account members.</p>
                        <span>Notice of Privacy Rights of California Residents</span>
                        <p>If you are a California resident and have provided personal information to the Site, you are
                            entitled by law to request certain information regarding any disclosure by the Site to third
                            parties of personal information for their direct marketing purposes. To make such a request,
                            send an email to support@worldofkink.com, specifying that you seek your “California Customer
                            Choice Privacy Notice.” Please allow thirty (30) days for a response. The Site is required to
                            respond to only one request per customer each year, and is not required to respond to requests
                            made by means other than through the above email address.</p>
                        <p>We will not share your personal information with third parties for their direct marketing
                            purposes if you request that we do not do so. You may make such a request by sending us an email
                            at support@worldofkink.com or mailing your request to:</p>
                        <p>Professional Idiots, Inc<br>
                            PO Box 1388<br>
                            Castle Rock, CO 80104</p>
                        <p>When contacting us, please indicate your name, address, email address, and what personal
                            information you do not want us to share with third parties for their direct marketing purposes.
                            Please note that there is no charge for controlling the sharing of your personal information or
                            for processing this request. </p>
                        <span>Minors</span>
                        <p>World of Kink does not allow anyone under the age if 18 to use the site.</p>
                        <span>Links to Other sites</span>
                        <p>This Site provides links and pointers to Web sites maintained by other organizations. The Site
                            provides these links as a convenience to users, but it does not operate, control or endorse such
                            sites. The Site also disclaims any responsibility for the information on those sites and any
                            products or services offered there, and cannot vouch for the privacy policies of such sites. The
                            Site does not make any warranties or representations that any linked sites (or even this Site)
                            will function without error or interruption, that defects will be corrected, or that the sites
                            and their servers are free of viruses and other problems that can harm your computer.</p>
                        <span>E-Commerce and Our Secure Server</span>
                        <p>We understand that storing data in a secure manner is important. We store personal information
                            using industry standard, reasonable and technically feasible, physical, technical and
                            administrative safeguards against foreseeable risks, such as unauthorized access. All commerce
                            transactions that take place on the Site are processed through our secure server in order to
                            make every reasonable effort to insure that your personal information is protected.</p>
                        <p>Please be aware that the Site and data storage are run on software, hardware and networks, any
                            component of which may, from time to time, require maintenance or experience problems or
                            breaches of security beyond the Site’s control. We cannot guarantee the security of the
                            information on and sent from the Site. </p>
                        <p>On our Site, you may have the opportunity to follow a link to other sites that may be of interest
                            to you. We are not responsible for the privacy practices of those sites or the content provided
                            thereon. We disclaim any responsibility for transactions conducted on those sites and cannot
                            vouch for the security of the information submitted in those transactions.</p>

                        <span>Policy Changes and Acceptance</span>
                        <p>The Privacy Policy may be revised from time to time as we add new features and services, as laws
                            change, and as industry privacy and security best practices evolve. We display an effective date
                            on the upper left corner of the Privacy Policy so that it will be easier for you to know when
                            there has been a change. Accordingly, you should check the Privacy Policy on a regular basis for
                            the most current privacy practices. Each time you access, use or browse the Site, you signify
                            your acceptance of the then-current changes to the Privacy Policy applying to your personal
                            information collected by us on and from the effective date of such changes.</p>
                        <p>Any changes in the Privacy Policy will take effect upon posting and apply only to information
                            collected from you on and after Last Revised date, unless we provide notice or have other
                            communications with you.</p>

                        <span>More Questions?</span>
                        <p>If you have any questions about this Privacy Policy, e-mail them to support@worldofkink.com, and
                            be sure to indicate the specific site you’re visiting and the nature of your question or
                            concern.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
@endsection
