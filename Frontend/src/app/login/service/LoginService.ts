import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BehaviorSubject, catchError, map, Observable, of } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private apiUrl = 'http://127.0.0.1:8000';
  private storageKey = 'user'; // Key for local storage
  private _showNavbar = new BehaviorSubject<boolean>(true);
  showNavbar$ = this._showNavbar.asObservable();
  private userId: number | null = null;

  constructor(private http: HttpClient) {
    this.loadUser();
  }

  private loadUser() {
    const userData = localStorage.getItem(this.storageKey);
    if (userData) {
      try {
        const user = JSON.parse(userData);
        this.userId = user.userId || null;
        console.log('User loaded from localStorage:', this.userId);
      } catch (error) {
        console.error('Error parsing user data from localStorage:', error);
      }
    } else {
      console.log('No user data found in localStorage');
    }
  }

  checklogin(email: string, password: string):
    Observable<{ success: boolean, user?: any, user_id?: number, token?: string, role_id?: number, email?: string }> {
    return this.http.post<any>(this.apiUrl + "/api/auth/login", { email, password })
      .pipe(
        map(response => {
          if (response.meta && response.meta.code === 200 && response.meta.status === 'success') {
            this._showNavbar.next(false);
            this.userId = response.data.user.user_id;
            this.saveUser(response.data.user); // Save complete user data to localStorage
            console.log('Login successful. User ID saved:', this.userId);
            return {
              success: true,
              user: response.data.user,
              token: response.data.access_token.token,
              role_id: response.data.user.role_id,
              email: response.email,
              user_id: response.data.user.user_id
            };
          } else {
            return { success: false };
          }
        }),
        catchError(error => {
          console.error('Error during login:', error);
          return of({ success: false });
        })
      );
  }

  usertype(role_id: number | undefined): Observable<any> {
    if (role_id === undefined) {
      return of({ success: false, role_name: 'Unknown' });
    }
    return this.http.get<any>(`${this.apiUrl}/api/roles/role/${role_id}`).pipe(
      map(response => {
        if (response.success) {
          return {
            success: true,
            role_name: response.role.role_name // Adjust based on the actual response structure
          };
        } else {
          return { success: false };
        }
      }),
      catchError(error => {
        console.error('Error occurred during role name retrieval', error);
        return of({ success: false, role_name: 'Error' });
      })
    );
  }

  getUserId(): number | null {
    console.log('Retrieved User ID:', this.userId);
    return this.userId;
  }

  private saveUser(user: any) {
    const userData = {
      userId: user.user_id,
      userType: user.role_id, // Or whatever user type information you have
      Useremail: user.email
    };
    localStorage.setItem(this.storageKey, JSON.stringify(userData));
    console.log('User saved to localStorage:', userData);
  }

  clearUser() {
    this.userId = null;
    localStorage.removeItem(this.storageKey);
    console.log('User cleared from localStorage');
  }
}
