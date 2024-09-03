import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class CreateaccountService {

  constructor(private http: HttpClient) { }
  createstaff(data:any){
    return this.http.post('http://localhost:8000/api/auth/registerstaff',data);
  }
}
