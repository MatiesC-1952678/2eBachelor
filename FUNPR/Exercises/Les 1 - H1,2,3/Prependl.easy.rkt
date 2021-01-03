(define Prependl
  (lambda (x y)
    (cond
      ((null? x) y)
      (else (cons (car x) (Prependl (cdr x) y)))
      )))

 (Prependl '(a b c) '(d e f))