import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuItemOrdersComponent } from './menu-item-orders.component';

describe('MenuItemOrdersComponent', () => {
  let component: MenuItemOrdersComponent;
  let fixture: ComponentFixture<MenuItemOrdersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MenuItemOrdersComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MenuItemOrdersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
