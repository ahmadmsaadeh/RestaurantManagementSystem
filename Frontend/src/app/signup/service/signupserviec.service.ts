import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {map, Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class SignupService {

  private apiUrl = 'http://127.0.0.1:8000';

  constructor(private http: HttpClient) {
  }

  signUp(data:any){
    return this.http.post('http://localhost:8000/api/auth/registercustomer',data);
  }
  // signup(
  //   email: string,
  //   password: string,
  //   username: string,
  //   firstname: string,
  //   lastname: string,
  //   phonenumber: string,
  // ): Observable<{ success: boolean; user?: any; token?: string;}> {
  //   return this.http.post<any>(`${this.apiUrl}/api/auth/registercustomer`, {
  //     email,
  //     password,
  //     username,
  //     firstname,
  //     lastname,
  //     phonenumber
  //   })
  //     .pipe(
  //       map(response => {
  //         if (response.meta && response.meta.code === 200 && response.meta.status === 'success') {
  //           return {
  //             success: true,
  //           };
  //         } else {
  //           return { success: false };
  //         }
  //       })
  //     );
  // }



}
