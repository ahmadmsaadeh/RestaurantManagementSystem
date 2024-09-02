// reset-password.component.ts
import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { AuthService } from './service/auth.service'; // Adjust the path as necessary

@Component({
  selector: 'app-reset-password',
  templateUrl: './resetpassword.component.html',
  styleUrls: ['./resetpassword.component.css']
})
export class ResetPasswordComponent {
  token: string | null = null;
  email: string | null = null;
  password: string | null = null;
  password_confirmation: string | null = null;

  constructor(private authService: AuthService, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.token = this.route.snapshot.queryParamMap.get('token');
    this.email = this.route.snapshot.queryParamMap.get('email');
  }

  resetPassword(resetPasswordForm: NgForm) {
    this.authService.resetPassword(this.token!, this.email!, this.password!, this.password_confirmation!).subscribe(
      data => {
        alert('Your password has been reset successfully.');
        resetPasswordForm.resetForm();
        // Optionally redirect to login page
      },
      error => {
        console.error('Error:', error);
        alert('There was an error resetting your password.');
      }
    );
  }
}
