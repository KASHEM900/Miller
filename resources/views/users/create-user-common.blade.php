
<tr>
    <td>ইউজার নাম<span style="color: red;"> * </span></td>
    <td><strong>:</strong></td>
    <td><input maxlength="99" placeholder="ইউজার নাম" type="text"
        name="name" id="name" class="form-control" value=""
        title="ইউজার নাম" required=""></td>
</tr>
<tr><td colspan="3" class="err_hide" align="right" id="name"></td></tr>

<tr>
    <td>ইউজার ইমেইল<span style="color: red;"> * </span></td>
    <td><strong>:</strong></td>
    <td><input maxlength="99" placeholder="ইউজার ইমেইল" type="email"
        name="email" id="email" class="form-control" value=""
        title="ইউজার ইমেইল" required=""></td>
</tr>
<tr><td colspan="3" class="err_hide" align="right" id="email"></td></tr>

<tr>
    <td>ইউজার ইমেইল নিশ্চিত<span style="color: red;"> * </span></td>
    <td><strong>:</strong></td>
    <td><input maxlength="99" placeholder="ইউজার ইমেইল নিশ্চিত" type="email"
        name="email_confirmation" id="email_confirmation" class="form-control" value=""
        title="ইইউজার ইমেইল নিশ্চিত" required=""></td>
</tr>

<tr>
    <td>পাসওয়ার্ড  <span style="color: red;"> * </span></td>
    <td><strong>:</strong></td>
    <td><input maxlength="99" minlength="8" type="password" id="password" name="password"
            title="পাসওয়ার্ড" value="" class="form-control"
            placeholder="পাসওয়ার্ড" required="" id="password">    </td>
</tr>
<tr><td colspan="3" id="password"></td></tr>

<tr>
    <td>পাসওয়ার্ড নিশ্চিত <span style="color: red;"> * </span></td>
    <td><strong>:</strong></td>
    <td><input id="password_confirmation" type="password" class="form-control"
        name="password_confirmation" required autocomplete="new-password"
        placeholder="পাসওয়ার্ড নিশ্চিত " required="" maxlength="99" minlength="8"></td>
</tr>

<tr>
    <td colspan="3" id="user_btn_hide"><p align="right">


        <br/>
        <input type="submit" id="user_submit" class="btn btn-primary"
        title="অনুগ্রহ করে সংরক্ষন করুন" value="সাবমিট ">
    </p></td>
</tr>


<script>

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}
</script>
