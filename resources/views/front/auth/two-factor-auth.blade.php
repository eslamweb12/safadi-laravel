<x-front-layout title="Login">

<!-- Start Account Login Area -->
<div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('login') }}" method="post">
                        @csrf
                        
                        <div class="card-body">
                           
                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                                <p>You can enable/diable 2fa</p>
                            </div>
                            
                          
                            <div class="button">
                                <button class="btn" type="submit">enable</button>
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>