import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private userType: string = '';
  private userId: number | null = null;
  private Useremail: string = '';

  constructor() {
    this.loadUser();
  }

  private loadUser() {
    const userData = localStorage.getItem('user');
    if (userData) {
      try {
        const user = JSON.parse(userData);
        this.userType = user.userType || ''; // Load userType from localStorage
        this.userId = user.userId || null; // Load userId from localStorage
        this.Useremail = user.Useremail || ''; // Load user email if needed
        console.log('User loaded from localStorage:', this.userType, this.userId, this.Useremail);
      } catch (error) {
        console.error('Error parsing user data from localStorage:', error);
      }
    } else {
      console.log('No user data found in localStorage');
    }
  }

  setUserType(type: string) {
    this.userType = type;
    this.saveUser(); // Save user data to localStorage when updated
  }

  getUserType(): string {
    return this.userType;
  }

  setUserId(id: number) {
    this.userId = id;
    this.saveUser(); // Save user data to localStorage when updated
  }

  getUserId(): number | null {
    return this.userId;
  }

  setUseremail(email: string) {
    this.Useremail = email;
    this.saveUser(); // Save user data to localStorage when updated
  }

  getUseremail(): string {
    return this.Useremail;
  }

  private saveUser() {
    const user = {
      userId: this.userId,
      userType: this.userType,
      Useremail: this.Useremail
    };
    localStorage.setItem('user', JSON.stringify(user));
    console.log('User saved to localStorage:', user);
  }
}
