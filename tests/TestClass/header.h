struct test_type1
{
    int int_field;
};

struct test_type2
{
	struct test_type1 array_of_struct[1];
};
