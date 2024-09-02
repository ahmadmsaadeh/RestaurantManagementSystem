import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders  } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MenuService {
  private apiUrl = 'http://localhost:8000/api/menu-items';
  constructor(private http: HttpClient) { }

  getMenuItems(): Observable<any> {
   // return this.http.get('http://localhost:8000/api/menu-items');
    return this.http.get<any>(this.apiUrl);
  }


  // add menu
  addMenuItem(formData: FormData): Observable<any> {
    return this.http.post<any>(this.apiUrl, formData, {
      headers: new HttpHeaders({
      //  'Content-Type': 'multipart/form-data'
      })
    });
  }
//

}
