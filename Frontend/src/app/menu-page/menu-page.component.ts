import { Component ,inject, OnInit  } from '@angular/core';
import { MenuService } from '../menu.service';

@Component({
  selector: 'app-menu-page',
  templateUrl: './menu-page.component.html',
  styleUrls: ['./menu-page.component.css']
})
export class MenuPageComponent implements OnInit{
  menuItems: any[] = [];

  //constructor(private menuService: MenuService) { }
  private menuService = inject(MenuService);  // Use inject to get MenuService

  ngOnInit(): void {
    this.getMenuItems();  // Call the method to fetch menu items
  }

  private getMenuItems(): void {
    this.menuService.getMenuItems().subscribe(
      (data: any[]) => {
        this.menuItems = data;
      },
      (error) => {
        console.error('Error fetching menu items', error);
      }
    );
  }
}
