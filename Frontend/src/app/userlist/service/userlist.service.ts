import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {map, Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UserlistService {

  private apiUrl = 'http://localhost:8000/api';  // Base URL

  constructor(private http: HttpClient) {
  }

  // Get all users
  getUserList(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/users`);
  }

  getRoleName(roleId: number): Observable<string> {
    return this.http.get<any>(`${this.apiUrl}/roles/role/${roleId}`).pipe(
      map(response => response.role.role_name)
    );
  }

  updateUser(userId: number, userData: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/users/${userId}`, userData);
  }

  deleteUser(userId: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/users/${userId}`);
  }

  addUser(userData: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/users`, userData);
  }

}
