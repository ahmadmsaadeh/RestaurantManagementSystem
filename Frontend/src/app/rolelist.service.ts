import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class RolelistService {

  private apiUrl = 'http://127.0.0.1:8000';

  constructor(private http: HttpClient) {
  }

  getallroles() {
    return this.http.get(this.apiUrl+"/api/roles");
  }

}
