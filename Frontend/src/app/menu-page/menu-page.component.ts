import {Component, EventEmitter, inject, OnInit, Output} from '@angular/core';
import { MenuService } from '../menu.service';
import { FeedbackService } from '../feedback.service';

@Component({
  selector: 'app-menu-page',
  templateUrl: './menu-page.component.html',
  styleUrls: ['./menu-page.component.css']
})
export class MenuPageComponent implements OnInit{
  menuItems: any[] = [];
  selectedItem: any = null;
  selectedCategory: string = 'all';

  filteredMenuItems: any[] = [];
  categories: any[] = [];
  selectedItemrating: any ; // rating

  selectedItemFeedback: any;
  averageRating: number = 0;
  comments: string[] = [];
  //constructor(private menuService: MenuService) { }
  private feedbackService=inject( FeedbackService)
  private menuService = inject(MenuService);  // Use inject to get MenuService
  @Output() itemAdded = new EventEmitter<any>();
  ngOnInit(): void {
   // this.getMenuItems();  // Call the method to fetch menu items
   // this.getCategories();
 /*   this.menuService.getCategories().subscribe((data) => {
      this.categories = data;
    });

    this.menuService.getMenuItems().subscribe((data) => {
      this.menuItems = data;
    });*/
  //  this.loadCategories();
    this.loadCategories();
    this.loadMenuItems();
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
  //
  private loadMenuItems(): void {
    this.menuService.getMenuItems().subscribe(
      (data: any[]) => {
        this.menuItems = data;
        this.filteredMenuItems = data; // Initialize filtered items
        console.log('All Menu Items:', data); // Debug: Print all menu items
      },
      (error) => {
        console.error('Error fetching menu items', error);
      }
    );
  }

  private loadCategories(): void {
    this.menuService.getCategories().subscribe(
      (data: any[]) => {
        this.categories = data;
        console.log('Categories:', data); // Debug: Print categories
      },
      (error) => {
        console.error('Error fetching categories', error);
      }
    );
  }

  filterByCategory(categoryId: string): void {
    this.selectedCategory = categoryId;
    console.log('Selected Category:', categoryId); // Debug: Print selected category

    if (categoryId === 'all') {
      this.filteredMenuItems = this.menuItems;
    } else {
      // Convert categoryId to a number if necessary
      this.filteredMenuItems = this.menuItems.filter(item => item.category_id === Number(categoryId));
    }
  }
//

 /* private loadMenuItems(): void {
    this.menuService.getMenuItems().subscribe(
      (data: any[]) => {
        this.menuItems = data;
        this.filteredMenuItems = data; // Initialize filtered items
      },
      (error) => {
        console.error('Error fetching menu items', error);
      }
    );
  }*/

  private getCategories(): void {
    this.menuService.getCategories().subscribe(
      (data: any[]) => {
        this.categories = data;
      },
      (error) => {
        console.error('Error fetching categories', error);
      }
    );
  }

 /* filterByCategory(event: any): void {
    const categoryId = event.target.value;
    if (categoryId === 'all') {
      this.menuService.getMenuItems().subscribe((data) => {
        this.menuItems = data;
      });
    } else {
      this.menuService.getMenuItemsByCategory(categoryId).subscribe((data) => {
        this.menuItems = data;
      });
    }
  }*/
/*  filterByCategory(categoryId: string): void {
    this.selectedCategory = categoryId;
    if (categoryId === 'all') {
      this.loadMenuItems();
    } else {
      this.menuService.getMenuItemsByCategory(categoryId).subscribe(
        (data: any[]) => {
          this.filteredMenuItems = data;
        },
        (error) => {
          console.error('Error fetching menu items by category', error);
        }
      );
    }
  }*/

  /* loadCategories(): void {
     this.menuService.getCategories().subscribe(
       (data: any[]) => {
         console.log('Categories:', data); // Log categories to console
         this.categories = data;
       },
       (error) => {
         console.error('Error fetching categories:', error);
       }
     );
   }*/

  /*private loadCategories(): void {
    this.menuService.getCategories().subscribe(
      (data: any[]) => {
        this.categories = data;
      },
      (error) => {
        console.error('Error fetching categories', error);
      }
    );
  }*/


  //
  showDetails(item: any): void {
    this.selectedItem = item;
    //Tala
    this.feedbackService.getItemFeedback(item.menu_item_id).subscribe((response) => {
      console.log(response.average_rating);
      this.averageRating = response.average_rating;
      this.comments = response.comments;
    });
  }

  closeDetails(): void {
    this.selectedItem = null;
  }

  orderNow(item: any): void {
    // alert(`You have ordered: ${item.menu_item_id}`);

    this.itemAdded.emit(item); // Emit the item to be added to the order
    // alert(`You have ordered: ${item.name_item}`);
  }

  getStarsArray(rating: number): number[] {
    return Array(5).fill(0).map((_, i) => i < rating ? 1 : 0);
  }

// By Tala
  getStarClass(rating: number, index: number): string {
    if (rating >= index) {
      return 'fa-star text-warning';
    } else if (rating >= index - 0.5) {
      return 'fa-star-half-alt text-warning';
    } else {
      return 'fa-star text-muted';
    }
  }

  selectRating(item: any, rating: number, event: any) {
    item.rating = rating;
    event.stopPropagation();
  }
  // rating
}
