import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-chefs',
  templateUrl: './chefs.component.html',
  styleUrls: ['./chefs.component.css']
})
export class ChefsComponent implements OnInit {
  users: any[] = [];

  constructor(private http: HttpClient) {}
  private apiUrl = 'http://localhost:8000/api/chef';
  ngOnInit(): void {
    this.fetchChefs();
  }

  fetchChefs(): void {
    this.http.get<any>(this.apiUrl)
      .subscribe(response => {
        this.users = response.users;
      });
  }
}
