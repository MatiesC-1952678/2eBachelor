(define duplicate
  (lambda (x)
    (cond
      ((null? x) '())
      (else (cons (car x) (cons (car x) (duplicate (cdr x)))))
            )))