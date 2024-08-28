import { TestBed } from '@angular/core/testing';

import { RolelistService } from './rolelist.service';

describe('RolelistService', () => {
  let service: RolelistService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(RolelistService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
