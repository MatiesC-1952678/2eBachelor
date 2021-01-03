(define atom?
  (lambda (x)
    (and (not (pair? x)) (not (null? x))
    )
  )
)

(define mystery
  (lambda (l)
    (cond
      ((atom? l) l) ((null? l) '())
         (else
          (cons (mystery (car l))
                (mystery (cdr l)))))))