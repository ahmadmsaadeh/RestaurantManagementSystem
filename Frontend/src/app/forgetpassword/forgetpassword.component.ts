// forgot-password.component.ts
import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { AuthService } from './service/auth.service'; // Adjust the path as necessary

@Component({
  selector: 'app-forgetpassword',
  templateUrl: './forgetpassword.component.html',
  styleUrls: ['./forgetpassword.component.css']
})
export class ForgetpasswordComponent {
  email: string | null = null;

  constructor(private authService: AuthService) { }

  requestPasswordReset(forgotPasswordForm: NgForm) {
    this.authService.forgotPassword(this.email).subscribe(
      data => {
        alert('Reset link has been sent to your email.');
        forgotPasswordForm.resetForm();
      },
      error => {
        console.error('Error:', error);
        alert('There was an error sending the reset link.');
      }
    );
  }
}
