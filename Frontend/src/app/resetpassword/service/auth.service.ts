import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'https://your-api-url.com/api/auth'; // Replace with your actual API URL

  constructor(private http: HttpClient) { }

  // Request password reset link
  forgotPassword(email: string | null): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/password/email`, { email });
  }

  // Reset the password
  resetPassword(token: string, email: string, password: string, password_confirmation: string): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/password/reset`, {
      token,
      email,
      password,
      password_confirmation
    });
  }
}
