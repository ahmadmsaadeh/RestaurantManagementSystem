import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RolelistService {

  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  getRoleList(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/roles`);
  }



  getUsersForRole(roleId: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/users/role/${roleId}`, {});
  }

  updaterole(roleId: number | undefined, roleData: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/roles/update/${roleId}`, roleData);
  }

  deleterole(roleId: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/roles/delete/${roleId}`, {});
  }

  addRole(roleData: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/roles/create/role`, roleData);
  }

}
