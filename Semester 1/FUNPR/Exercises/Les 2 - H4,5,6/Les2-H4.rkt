(define atom?
  (lambda (x)
    (and (not (pair? x)) (not (null? x))
    )
  )
)

(define lat?
  (lambda (l)
    (cond
	((null? l) #t)
	((atom? (car l)) (lat? (cdr l)))
	(else #f)
    )
  )
)

(define member?
  (lambda (a lat)
    (cond
      ((null? lat) #f)
      (else (or (eq? (car lat) a) 
                (member? a (cdr lat))
            )
      )
    )
  )
)

(define rember
  (lambda (a lat)
    (cond
      ((null? lat) (quote ()))
      ((eq? (car lat) a) (cdr lat))
      (else (cons (car lat) (rember a (cdr lat))))
    )
  )
)

(define firsts
  (lambda (l)
    (cond
      ((null? l) (quote ()))
      (else (cons (car (car l)) 
                  (firsts (cdr l))
            )
      )
    )
  )
)

(define insertR
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons pat (cons adda (cdr lat))))
              (else (cons (car lat) (insertR adda pat (cdr lat))))
            )
      )
    )
  )
)

(define insertL
  (lambda (adda pat lat)
    (cond
      ((null? lat) (quote ()))
      (else (cond
              ((eq? (car lat) pat) (cons adda (cons pat (cdr lat))))
              (else (cons (car lat) (insertL adda pat (cdr lat))))
            )
      )
    )
  )
)

(define add1
  (lambda (n)
    (+ n 1)))

(define sub1
  (lambda (n)
    (- n 1)))

;--- plus (+) ---
(define plus
  (lambda (n m)
    (cond
      ((zero? m) n)
      (else (add1 (plus n (sub1 m))))
      )))


;--- minus (-) ---
(define minus
  (lambda (n m)
    (cond
      ((zero? m) n)
      (else (sub1 (minus n (sub1 m))))
      )))

;--- times (x) ---
(define times
  (lambda (n m)
    (cond
      ((zero? m) 0)
      (else (plus n (times n (sub1 m))))
      )))

(define smth
  (lambda (n m)
    (cond
      ((zero? m) #f)
      ((zero? n) #t)
      (else (smth (sub1 n) (sub1 m)))
      )))

(define div
  (lambda (n m)
    (cond
      ((smth n m) 0)
      (else (add1 (div (minus n m) m)))
      )))

(define f-to-c
  (lambda (x)
    (minus (div (times (plus x 40) 5) 9) 40)
    ))

(define c-to-f
  (lambda (x)
    (minus (div (times (plus x 40) 9) 5) 40)
    ))

(define div3
  (lambda (x)
    (cond
      ((zero? x) #t)
      ((= x 1) #f)
      ((= x 2) #f)
      (else (div3 (minus x 3)))
      )))

(define macht
  (lambda (m n)
    (cond
      ((= n 1) m)
      (else (* m (macht m (sub1 n))))
      )))

;--- (macht 10 3) ---

(define machten
  (lambda (m n)
    (cond
      ((zero? n) '(1))
      (else (cons (macht m n) (machten m (sub1 n)))))
      ))

;--- (machten 3 5) ---

(define mystery2 (lambda (x)
(cond ((atom? x) 0) ((null? x) 1)
(else (max
(+ (mystery2 (car x)) 1)
(mystery2 (cdr x)))))))

;--- this is a beautiful function that counts how deep the lists go, very nice ---

;--- the newton raphson loop of the method ---
(define newtonLoop
  (lambda (x guess tolerance)
    (cond
      ((> (minus x (macht guess 2)) tolerance) guess)
      (else (newtonLoop x (div (plus guess (div x guess)) 2) tolerance))
      )))
;--- the main newton raphson method ---
(define newton
  (lambda (x tolerance)
     (newtonLoop x (div x 2) tolerance)
    ))

(define convert
  (lambda (x)
    (cond
      ((= (length x) 1) (car x))
      (else (+ (*
             (car x) (expt 10 (sub1 (length x)))
             ) (convert(cdr x)))
            ))))

(define eliminate
  (lambda (limit l)
    (cond
      ((null? l) '())
      ((>= limit (car l))
           (cons (car l) (eliminate limit (cdr l))))
      (else (eliminate limit (cdr l)))
      )))
(eliminate '1.0 '(2.95 0.95 1.0 5))