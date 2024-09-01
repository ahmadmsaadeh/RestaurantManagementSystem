import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class TableServicesService {

  private  getDataUrl = 'http://localhost:8000/api/tables';
  constructor(private http: HttpClient) { }

  getAllTables(): Observable<any[]> {
    return this.http.get<any[]>(this.getDataUrl);
  }

  getTable(id: number): Observable<any> {
    return this.http.get<any>(`${this.getDataUrl}/${id}`);
  }

  addTable(numberOfChairs: number): Observable<any> {
    return  this.http.post(`${this.getDataUrl}/${numberOfChairs}`,'');
  }

  deleteTable(id: number): Observable<any> {
    return this.http.delete<any>(`${this.getDataUrl}/${id}`);
  }
}
