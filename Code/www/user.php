
<div id="editUserName" class="editUser" style="display:block">
	<form action="editUser.php" method="post" onSubmit="return checkPasswordMail()">
    Name<input type="text" name="editName" value="<? echo $logged['name']?>" maxlength="20" required>
    <p>Email<input id="mailUser" type="email" name="mail" value="<? echo $logged['mail']?>" maxlength="45" required> </p>
    <p>Password<input id="passwordUser" type="password" name="password" maxlength="30" required></p>
    <button style="float:right">Modify</button>
    </form>
    <button style="float:left" onClick="cancelEdit()">Cancel</button>
    <button onClick="showDiv('editUserName','editUserPass')">Change Password</button>
    <button style="float:right" onClick="showDiv('editUserName','editDeleteUser')">Delete User</button>
    
</div>

<div id="editUserPass" class="editUser" style="height: 110px">
	<form name="formPass" action="editUser.php" method="post" onSubmit="return checkPass()">
    Old password<input id="passUser" type="password" name="oldPassword" maxlength="30" required>
    <p>New Password<input type="password" name="newPassword" maxlength="30" required> </p>
    <p>Repeat<input id="newPassUser" type="password" name="newPassword2" maxlength="30" required></p>
    <button style="float:right">Modify</button>
    </form>
    <button style="float:left" onClick="cancelEdit()">Cancel</button>
</div>

<div id="editDeleteUser" class="editUser" style="height: 60px">
    
    <form action="editUser.php" method="post" onSubmit="return deleteUser()">
    Please write your password to delete the user.
    <p><input id="passUserDelete" type="password" name="deleteUserPass" placeholder="Password" maxlength="30" required> </p>
    <button style="width:25%; float:right">Delete</button>
    </form>
    <button style="width:22%; position:absolute; right:106px" onClick="cancelEdit()">Cancel</button>

</div>
