<?php

namespace tests\codeception\unit;

use an602\modules\user\models\Password;
use tests\codeception\_support\an602DbTestCase;

class AdditionalPasswordValidationTest extends an602DbTestCase
{
    protected $password;

    public function setUp(): void
    {
        $this->password = new Password();
        parent::setUp();
    }

    public function testValidateNewPasswordNeedsToBeAtLeast8CharactersLong()
    {
        $this->password->newPassword = 'qWErty';
        $this->assertFalse($this->password->validate(['newPassword']));

        $this->password->newPassword = 'qWErtyqwerty';
        $this->assertTrue($this->password->validate(['newPassword']));
    }

    public function testValidateNewPasswordHasToContainTwoUppercaseLetter()
    {
        $this->password->newPassword = 'qwertyqwerty';
        $this->assertFalse($this->password->validate(['newPassword']));

        $this->password->newPassword = 'qWErtyqwerty';
        $this->assertTrue($this->password->validate(['newPassword']));
    }

    public function testValidateNewPasswordConfirmNeedsToBeAtLeast8CharactersLong()
    {
        $this->password->newPasswordConfirm = 'qWErty';
        $this->assertFalse($this->password->validate(['newPasswordConfirm']));

        $this->password->newPasswordConfirm = 'qWErtyqwerty';
        $this->assertTrue($this->password->validate(['newPasswordConfirm']));
    }

    public function testValidateNewPasswordConfirmHasToContainTwoUppercaseLetter()
    {
        $this->password->newPasswordConfirm = 'qwertyqwerty';
        $this->assertFalse($this->password->validate(['newPasswordConfirm']));

        $this->password->newPasswordConfirm = 'qWErtyqwerty';
        $this->assertTrue($this->password->validate(['newPasswordConfirm']));
    }
}
