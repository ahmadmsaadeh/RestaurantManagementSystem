import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TablesManagementComponent } from './tables-management.component';

describe('TablesManagmentComponent', () => {
  let component: TablesManagementComponent;
  let fixture: ComponentFixture<TablesManagementComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TablesManagementComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TablesManagementComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
