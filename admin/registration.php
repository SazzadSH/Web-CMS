<html>
	<body>
		<form action="validate.php" method="POST">
		<table align="center" width="400" height="300">
		 <tr>
			<td>
				<fieldset>
					<legend>REGISTRATION</legend>
					<table align="left" width="400">
						<br>
						<tr>
							<td>Name:</td>
							<td colspan="2"><input type="text" name="name" align="right"/></td>
						</tr>
						<tr>
							<td >Email: </td>
							<td colspan="2"><input type="text" name="email"/> <b>i</b></td>
						</tr>
						<tr>
							<td>User Name: </td>
							<td colspan="2"><input type="text" name="username"/></td>
						</tr>
						<tr>
							<td>Password: </td>
							<td colspan="2"><input type="password" name="password"/></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2"><font size="1">*must contain atleast one of the special characters (@, #, $, %)</font></td>
						</tr>
						<tr>
							<td>Confirm Password: </td>
							<td colspan="2"><input type="password" name="confirmpassword"/></td>
						</tr>
						<tr>
							<td colspan="3">
								<fieldset>
									<legend>Gender</legend>
									<input type="radio" name="gender" value="male" checked/>MALE <input type="radio" name="gender" value="female"/>FEMALE <input type="radio" name="gender" value="Other"/>OTHER
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr></td>
						</tr>
						<tr>
							<td colspan="3">
								<fieldset>
									<legend>DATE OF BIRTH</legend>
									<table>
										<tr>
											<td colspan="3">
												<input type="text" name="dd" size="5"/>/ <input type="text" name="mm" size="5"/>/ <input type="text" name="yyyy" size="5"/>  (dd/mm/yyyy)
											</td>
										</tr>
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<hr>
							</td>
						</tr>
						<tr>
							<td><input type="submit" value="SUBMIT" name="SubmitRegistration"/> <input type="button" value="RESET" onclick="window.location.href='registration.php'"></td>
						</tr>
					</table>
					
				</fieldset>
			</td>
		 </tr>
		</table>
		</form>
	</body>
</html>
