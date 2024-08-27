import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {catchError, map, Observable, of, switchMap} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private apiUrl = 'http://127.0.0.1:8000';

  constructor(private http: HttpClient) {
  }

//   checklogin(email: string, password: string):
//     Observable<{ success: boolean, user?: any, token?: string, role_id?: number }> {
//     return this.http.post<any>(this.apiUrl + "/api/auth/login", {email, password})
//       .pipe(
//         map(response => {
//           if (response.meta && response.meta.code === 200 && response.meta.status === 'success') {
//             return {
//               success: true,
//               user: response.data.user,           // User information
//               token: response.data.access_token.token,  // Access token
//               role_id: response.data.user.role_id      // Role ID
//             };
//           } else {
//             return {success: false};
//           }
//         })
//       );
//   }
// }

//
  checklogin(email: string, password: string):
    Observable<{ success: boolean, user?: any, token?: string, role_id?: number }> {
    return this.http.post<any>(this.apiUrl + "/api/auth/login", {email, password})
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
            return {success: false};
          }
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



}


