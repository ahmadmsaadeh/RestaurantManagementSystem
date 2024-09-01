import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RoleslistComponent } from './roleslist.component';

describe('RoleslistComponent', () => {
  let component: RoleslistComponent;
  let fixture: ComponentFixture<RoleslistComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RoleslistComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RoleslistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
