<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>পাসওয়ার্ড পরিবর্তন</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  text-2xl flex justify-between">
                    <span>পাসওয়ার্ড পরিবর্তন</span>
                </div>

                <div class="card-body">
                    <div id="user_div">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                            <strong>দুঃখিত!</strong> আপনার এন্ট্রি করতে কোনো সমস্যা হয়েছে|<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <fieldset>
                            <form action="{{ route('loginchangeuserpassword') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <table>
                                <tbody>
                                <tr>
                                    <td>ইউজার নাম<span style="color: red;"> * </span></td>
                                    <td><strong>:</strong></td>
                                    <td><input maxlength="99" placeholder="ইউজার নাম" type="text"
                                    name="name" id="name" class="form-control" value="{{ Auth::user()->name }}"
                                        title="ইউজার নাম"  readonly></td>
                                </tr>

                                <tr>
                                    <td>পাসওয়ার্ড  <span style="color: red;"> * </span></td>
                                    <td><strong>:</strong></td>
                                    <td><input maxlength="99" minlength="8" type="password" name="password"
                                            title="পাসওয়ার্ড" value="" class="form-control"
                                            placeholder="পাসওয়ার্ড" required="" id="password">    </td>
                                </tr>
                                <tr><td colspan="3" id="password"></td></tr>

                                <tr>
                                    <td>পাসওয়ার্ড নিশ্চিত <span style="color: red;"> * </span></td>
                                    <td><strong>:</strong></td>
                                    <td><input id="password-confirm" type="password" class="form-control"
                                        name="password-confirm" required
                                        placeholder="পাসওয়ার্ড নিশ্চিত " required="" maxlength="99" minlength="8"></td>
                                </tr>
                                <tr><td colspan="3" id="password_confirmation"></td></tr>


                                <tr>
                                    <td colspan="3" id="user_btn_hide"><p align="right">


                                        <br/>
                                        <input type="submit" id="user_submit" class="btn btn-primary"
                                        title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
                                    </p></td>
                                </tr>
                                </tbody>
                                </table>
                            </form>
                        </fieldset>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</body>
</html>


