<?php
require('../tund4/functions.php');

    $notice = "";
    $errors = [];
    $fields = [
        'firstName' => '',
        'lastName' => '',
        'birthDate' => '',
        'gender' => '',
        'email' => '',
        'birthYear' => null,
        'birthMonth' => null,
        'birthDay' => null,
        'password' => "",
        'passwordConfirm' => "",
    ];

    if(isset($_POST['submitUserData']) && $_POST['submitUserData']) {
        foreach($fields as $key => $field) {
            if($key == 'birthDate') continue;
            $fields[$key] = escapePostData($key);
            if(empty($fields[$key]) or is_null($fields[$key])) {
                $errors[$key] = "Palun täida {$key} lahter";
            }
        }

        if($fields['password'] != $fields['passwordConfirm']) $errors[] = "Paroolid ei klapi.";

        if($fields['birthYear'] != null && $fields['birthMonth'] != null && $fields['birthDay'] != null) {
            $fields['birthDate'] = date_create($fields['birthYear'].'/'.$fields['birthMonth'].'/'.$fields['birthDay']);
            $fields['birthDate'] = date_format($fields['birthDate'], "Y-m-d");
        }

        if(!count($errors)) {
            $notice = insertInto('vpusers', [
                'firstname' => $fields['firstName'],
                'lastname' => $fields['lastName'],
                'password_hash' => password_hash($fields['password'], PASSWORD_BCRYPT),
                'gender' => $fields['gender'],
                'email' => $fields['email'],
                'birthdate' => $fields['birthDate']
            ]);
        }
    }


	$months = [
		'et' => [
			1 => 'Jaanuar',
			2 => 'Veebruar',
			3 => 'Märts',
			4 => 'Aprill',
			5 => 'Mai',
			6 => 'Juuni',
			7 => 'Juuli',
			8 => 'August',
			9 => 'September',
			10 => 'Oktoober',
			11 => 'November',
			12 => 'Detsember',
		]
	];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>IF18 praktikum</title>
		<link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet"> 
	</head>

	<body>
		<div class="center">
            <h1><?= basename(__FILE__) ?></h1>
            <p class="notice"><?= $notice ?></p>

			<hr>
			<form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
				<div class="pictures">

                    <div class="form-input">
                        <span class="error"><?= ShowError('firstName') ?></span>
                        <label for="firstName">Eesnimi</label>
                        <input type="text" value="<?= GetFieldValue('firstName') ?>" name="firstName" />
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('lastName') ?></span>
                        <label for="lastName">Perenimi</label>
                        <input type="text" value="<?= GetFieldValue('lastName') ?>" name="lastName" />
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('email') ?></span>
                        <label for="email">Email</label>
                        <input type="email" value="<?= GetFieldValue('email') ?>" name="email" />
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('password') ?></span>
                        <label for="password">Password</label>
                        <input type="password" name="password" />
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('passwordConfirm') ?></span>
                        <label for="passwordConfirm">Confirm password</label>
                        <input type="password" name="passwordConfirm" />
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('birthDay') ?></span>
                        <label></label>
                        <select name="birthDay">
                            <option value="" selected disabled>Päev</option>
                            <?php for($i = 0; $i <= 31; $i++): ?>
                                <option <?= GetFieldValue('birthDay') == $i ? 'checked' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select><br>
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('birthMonth') ?></span>
                        <label></label>
                        <select name="birthMonth">
                            <option value="" selected disabled>Kuu</option>
                            <?php foreach($months['et'] as $key => $month): ?>
                                <option <?= GetFieldValue('birthMonth') == $key ? 'checked' : '' ?> value="<?= $key ?>"><?= $month ?></option>
                            <?php endforeach; ?>
                        </select><br>
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('birthYear') ?></span>
                        <label></label>
                        <select name="birthYear">
                            <option value="" selected disabled>Aasta</option>
                            <?php for($i = date('Y') - 100; $i <= date('Y') - 15; $i++): ?>
                                <option  <?= GetFieldValue('birthYear') == $i ? 'checked' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select><br>
                    </div>

                    <div class="form-input">
                        <span class="error"><?= ShowError('gender') ?></span>
                        <label></label>
                        <input type="radio" name="gender" <?= GetFieldValue('gender') == 1 ? 'checked' : '' ?> value="1"> Naine
                        <input type="radio" name="gender" <?= GetFieldValue('gender') == 2 ? 'checked' : '' ?> value="2"> Mees
                    </div>
					<input type="submit" name="submitUserData" value="Saada andmed" />
				</div>
			</form>
		</div>
	</body>
</html> 