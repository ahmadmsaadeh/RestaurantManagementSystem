import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class SignupserviecService {

  private apiUrl = 'http://127.0.0.1:8000';

  constructor(private http: HttpClient) {
  }
  signup(
    email: string,
    password: string,
    username: string,
    firstname: string,
    lastname: string,
    phonenumber: string
  ): Observable<{ success: boolean; user?: any; token?: string; role_id?: number }> {
    return this.http.post<any>(`${this.apiUrl}/api/auth/registercustomer`, {
      email,
      password,
      username,
      firstname,
      lastname,
      phonenumber
    })
      .pipe(
        map(response => {
          if (response.meta && response.meta.code === 200 && response.meta.status === 'success') {
            return {
              success: true,
              user: response.data.user,
              token: response.data.access_token.token,
              role_id: response.data.user.role_id
            };
          } else {
            return { success: false };
          }
        })
      );
  }



}
